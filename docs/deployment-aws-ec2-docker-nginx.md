# Huong dan deploy production tu A-Z: AWS EC2 + Docker + Nginx + GitHub Actions + DuckDNS

Tai lieu nay viet rieng cho project Laravel Hotel Booking hien tai. Cac file deploy da co trong repo:

- `Dockerfile`: build 2 image production, gom Laravel PHP-FPM va Nginx.
- `docker-compose.prod.yml`: chay `app`, `nginx`, `db`, `queue`, `scheduler`, `certbot`.
- `docker-compose.duckdns-https.yml`: overlay bat HTTPS khi da co certificate.
- `docker/nginx/default.conf`: Nginx HTTP va ACME challenge cho Let's Encrypt.
- `docker/nginx/https.conf.template`: Nginx HTTPS template dung bien `DUCKDNS_DOMAIN`.
- `.github/workflows/deploy-production.yml`: CI/CD GitHub Actions.

Quy uoc branch:

- Push len `dev`: chi chay test/build frontend, khong deploy.
- Push len `main` hoac `production`: test -> build Docker images -> push GHCR -> SSH vao EC2 -> restart containers -> migrate -> cache config/view.

> Luu y quan trong: khong commit `.env`, token, private key, database password vao repo.

## 0. Ban can co nhung gi

Truoc khi bat dau, chuan bi:

- Tai khoan AWS.
- Tai khoan GitHub co repo cua project.
- Tai khoan DuckDNS.
- May local co Git va SSH.
- Mot email that de dang ky Let's Encrypt certificate.
- Repo da push len GitHub.

Vi du trong tai lieu:

```text
EC2 user: ec2-user
EC2 app folder: /opt/hotel-booking
DuckDNS subdomain: hotelhub-demo
DuckDNS full domain: hotelhub-demo.duckdns.org
Production branch: main
```

Khi lam that, thay cac gia tri tren bang gia tri cua ban.

## 1. Kiem tra repo local truoc khi deploy

O may local, tai thu muc project:

```bash
git status
npm run build
php artisan test
```

Neu test local can MySQL va chua cau hinh duoc, co the bo qua buoc `php artisan test` local, vi GitHub Actions se chay test voi MySQL service rieng.

Kiem tra cac file deploy ton tai:

```bash
ls Dockerfile
ls docker-compose.prod.yml
ls docker-compose.duckdns-https.yml
ls .github/workflows/deploy-production.yml
ls docker/nginx/default.conf
ls docker/nginx/https.conf.template
```

## 2. Tao EC2 tren AWS

1. Vao AWS Console -> EC2 -> Launch instance.
2. Name: `hotel-booking-production`.
3. AMI: Amazon Linux 2023.
4. Instance type:
   - Toi thieu: `t3.small`.
   - Nen dung: `t3.medium` neu co traffic, queue, MySQL cung may.
5. Key pair:
   - Tao key pair moi, vi du `hotel-booking-prod.pem`.
   - Tai file `.pem` ve may va giu can than.
6. Storage:
   - Toi thieu 20GB.
   - Nen 30GB tro len vi Docker images + MySQL volume se tang dan.

Security Group inbound:

```text
SSH   22   Your IP only
HTTP  80   0.0.0.0/0
HTTPS 443  0.0.0.0/0
```

Khong mo port MySQL `3306` ra internet. MySQL chi chay trong Docker network noi bo.

## 3. Gan Elastic IP cho EC2

Nen dung Elastic IP de DuckDNS khong bi doi IP khi restart EC2:

1. EC2 -> Elastic IPs -> Allocate Elastic IP address.
2. Chon Elastic IP vua tao -> Actions -> Associate Elastic IP address.
3. Chon instance `hotel-booking-production`.
4. Ghi lai IP, vi du:

```text
YOUR_EC2_ELASTIC_IP=13.250.10.20
```

## 4. SSH vao EC2 lan dau

Tren may local:

```bash
chmod 400 hotel-booking-prod.pem
ssh -i hotel-booking-prod.pem ec2-user@YOUR_EC2_ELASTIC_IP
```

Neu dung Windows PowerShell va `chmod` khong co, co the SSH truc tiep:

```powershell
ssh -i .\hotel-booking-prod.pem ec2-user@YOUR_EC2_ELASTIC_IP
```

Neu bi loi permission key tren Windows, vao file `.pem` -> Properties -> Security -> chi giu quyen doc cho user hien tai.

## 5. Cai Docker va Docker Compose tren EC2

Trong SSH EC2:

```bash
sudo yum update -y
sudo yum install docker -y
sudo service docker start
sudo systemctl enable docker
sudo usermod -aG docker ec2-user
exit
```

Dang nhap lai EC2 de group `docker` co hieu luc:

```bash
ssh -i hotel-booking-prod.pem ec2-user@YOUR_EC2_ELASTIC_IP
```

Kiem tra:

```bash
docker info
docker compose version
```

Neu `docker compose version` bao chua co plugin, cai them:

```bash
sudo mkdir -p /usr/local/lib/docker/cli-plugins
sudo curl -SL https://github.com/docker/compose/releases/download/v2.32.4/docker-compose-linux-x86_64 -o /usr/local/lib/docker/cli-plugins/docker-compose
sudo chmod +x /usr/local/lib/docker/cli-plugins/docker-compose
docker compose version
```

Tao thu muc app:

```bash
sudo mkdir -p /opt/hotel-booking
sudo chown -R ec2-user:ec2-user /opt/hotel-booking
```

## 6. Tao SSH key rieng cho GitHub Actions deploy

Khong nen dung key `.pem` AWS lam CI key. Tao key rieng cho GitHub Actions.

Tren may local:

```bash
ssh-keygen -t ed25519 -C "github-actions-hotel-production" -f hotel-production-deploy-key
```

Lenh nay tao 2 file:

```text
hotel-production-deploy-key
hotel-production-deploy-key.pub
```

Copy public key len EC2:

```bash
ssh-copy-id -i hotel-production-deploy-key.pub ec2-user@YOUR_EC2_ELASTIC_IP
```

Neu Windows khong co `ssh-copy-id`, dung cach thu cong:

```powershell
Get-Content .\hotel-production-deploy-key.pub
```

Copy noi dung public key. SSH vao EC2 bang `.pem`, roi chay:

```bash
mkdir -p ~/.ssh
chmod 700 ~/.ssh
nano ~/.ssh/authorized_keys
```

Dan public key vao cuoi file, save, roi:

```bash
chmod 600 ~/.ssh/authorized_keys
```

Kiem tra deploy key:

```bash
ssh -i hotel-production-deploy-key ec2-user@YOUR_EC2_ELASTIC_IP "docker info"
```

Neu lenh tren chay duoc, private key `hotel-production-deploy-key` se dua vao GitHub secret `EC2_SSH_PRIVATE_KEY`.

## 7. Tao DuckDNS domain

1. Vao DuckDNS va dang nhap.
2. Tao subdomain, vi du:

```text
hotelhub-demo
```

Domain day du:

```text
hotelhub-demo.duckdns.org
```

3. Trong DuckDNS, cap nhat IP cua domain thanh Elastic IP EC2.
4. Hoac mo URL update theo mau:

```text
https://www.duckdns.org/update?domains=hotelhub-demo&token=YOUR_DUCKDNS_TOKEN&ip=YOUR_EC2_ELASTIC_IP
```

Ket qua dung:

```text
OK
```

5. Kiem tra DNS:

```bash
nslookup hotelhub-demo.duckdns.org
```

IP tra ve phai trung voi Elastic IP cua EC2.

Neu khong dung Elastic IP, co the tao cron update DuckDNS tren EC2:

```bash
mkdir -p ~/duckdns
echo 'echo url="https://www.duckdns.org/update?domains=hotelhub-demo&token=YOUR_DUCKDNS_TOKEN&ip=" | curl -k -o ~/duckdns/duck.log -K -' > ~/duckdns/duck.sh
chmod 700 ~/duckdns/duck.sh
(crontab -l 2>/dev/null; echo "*/5 * * * * ~/duckdns/duck.sh >/tmp/duckdns.log 2>&1") | crontab -
```

Production nen dung Elastic IP de on dinh hon.

## 8. Tao GitHub token de EC2 pull image tu GHCR

GitHub Actions dung `GITHUB_TOKEN` de push image len GHCR. EC2 can token rieng de pull image.

1. GitHub -> Settings -> Developer settings -> Personal access tokens.
2. Tao token cho user cua ban.
3. Quyen can co:
   - Repository access toi repo nay.
   - Package/container registry read permission.
   - Neu dung classic token, can `read:packages`.
4. Luu token lai, se dua vao secret `GHCR_TOKEN`.

Neu package GHCR cua repo private, token nay bat buoc phai pull duoc image.

## 9. Tao APP_KEY production

Tren may local co PHP:

```bash
php artisan key:generate --show
```

Neu khong co PHP local, dung Docker:

```bash
docker run --rm php:8.3-cli php -r "echo 'base64:'.base64_encode(random_bytes(32)).PHP_EOL;"
```

Copy ket qua, vi du:

```text
base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx=
```

Gia tri nay dua vao `APP_KEY`.

## 10. Tao GitHub Actions secrets

Vao GitHub repo -> Settings -> Secrets and variables -> Actions -> New repository secret.

Tao cac secret sau:

```text
EC2_HOST=YOUR_EC2_ELASTIC_IP
EC2_USER=ec2-user
EC2_SSH_PRIVATE_KEY=<noi dung private key hotel-production-deploy-key>
GHCR_USERNAME=<github username cua ban>
GHCR_TOKEN=<token co quyen read package>
PROD_ENV_FILE=<toan bo noi dung .env.production ben duoi>
```

De lay private key:

```bash
cat hotel-production-deploy-key
```

Windows PowerShell:

```powershell
Get-Content .\hotel-production-deploy-key -Raw
```

Copy toan bo noi dung, gom ca:

```text
-----BEGIN OPENSSH PRIVATE KEY-----
...
-----END OPENSSH PRIVATE KEY-----
```

## 11. Noi dung PROD_ENV_FILE lan dau, chay HTTP truoc

Lan dau nen chay HTTP truoc de certbot co the xac thuc domain. Tao secret `PROD_ENV_FILE` voi noi dung mau:

```env
APP_NAME="Hotel Booking"
APP_ENV=production
APP_KEY=base64:PASTE_APP_KEY_HERE
APP_DEBUG=false
APP_URL=http://hotelhub-demo.duckdns.org
DUCKDNS_DOMAIN=hotelhub-demo.duckdns.org
ENABLE_DUCKDNS_HTTPS=false

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=hotel_booking_reservation_system
DB_USERNAME=hotel_user
DB_PASSWORD=CHANGE_TO_STRONG_DB_PASSWORD
DB_ROOT_PASSWORD=CHANGE_TO_STRONG_ROOT_PASSWORD

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=false

CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=
PAYPAL_SANDBOX_CLIENT_SECRET=
PAYPAL_LIVE_CLIENT_ID=
PAYPAL_LIVE_CLIENT_SECRET=
PAYPAL_LIVE_APP_ID=
PAYPAL_PAYMENT_ACTION=Sale
PAYPAL_CURRENCY=USD
PAYPAL_NOTIFY_URL=
PAYPAL_LOCALE=en_US
PAYPAL_VALIDATE_SSL=true
PAYPAL_TIMEOUT=30
PAYPAL_CONNECT_TIMEOUT=10
PAYPAL_MAX_RETRIES=2

STRIPE_KEY=
STRIPE_SECRET=

VNP_RETURN_URL=http://hotelhub-demo.duckdns.org/vnpay-return
VITE_APP_NAME="${APP_NAME}"
```

Bat buoc thay:

```text
PASTE_APP_KEY_HERE
hotelhub-demo.duckdns.org
CHANGE_TO_STRONG_DB_PASSWORD
CHANGE_TO_STRONG_ROOT_PASSWORD
```

Neu chua cau hinh mail/payment production, cu de `MAIL_MAILER=log` va payment sandbox/empty de deploy truoc.

## 12. Push workflow len GitHub

Dam bao cac file deploy da duoc commit:

```bash
git status
git add .dockerignore Dockerfile docker-compose.prod.yml docker-compose.duckdns-https.yml docker .github docs
git commit -m "Add production Docker CI/CD deployment"
git push origin dev
```

Push len `dev` chi de test CI. Neu job `Test Laravel` xanh, merge len `main` hoac `production`.

Vi du deploy bang `main`:

```bash
git checkout main
git merge dev
git push origin main
```

Hoac neu ban dung branch `production`:

```bash
git checkout production
git merge dev
git push origin production
```

## 13. Theo doi GitHub Actions

Vao GitHub repo -> Actions -> `CI/CD Production`.

Neu push `main` hoac `production`, workflow se co 3 job:

```text
Test Laravel
Build and Push Images
Deploy to EC2
```

Ket qua mong doi:

```text
Test Laravel: xanh
Build and Push Images: xanh
Deploy to EC2: xanh
```

Sau khi deploy thanh cong, GitHub Actions se upload tren EC2:

```text
/opt/hotel-booking/docker-compose.prod.yml
/opt/hotel-booking/docker-compose.duckdns-https.yml
/opt/hotel-booking/nginx-https.conf.template
/opt/hotel-booking/.env.production
/opt/hotel-booking/.env.compose
```

`.env.compose` la file workflow tao ra, gom bien production va image tag vua build.

## 14. Kiem tra deploy HTTP tren EC2

SSH vao EC2:

```bash
ssh -i hotel-production-deploy-key ec2-user@YOUR_EC2_ELASTIC_IP
cd /opt/hotel-booking
```

Kiem tra containers:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml ps
```

Kiem tra log:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml logs -f app
docker compose --env-file .env.compose -f docker-compose.prod.yml logs -f nginx
docker compose --env-file .env.compose -f docker-compose.prod.yml logs -f db
```

Kiem tra Laravel:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app php artisan about
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app php artisan migrate:status
```

Mo trinh duyet:

```text
http://hotelhub-demo.duckdns.org
```

Neu domain chua vao duoc, thu IP:

```text
http://YOUR_EC2_ELASTIC_IP
```

Neu IP vao duoc ma domain khong vao duoc, loi nam o DuckDNS/DNS.

## 15. Import database mau neu ban can du lieu co san

Workflow mac dinh da chay:

```bash
php artisan migrate --force
```

Neu ban muon dung du lieu tu file `hotel_booking_reservation_system.sql`, hay can than: file SQL full dump co the trung table voi migrations da chay.

Lua chon an toan nhat:

- Production that: dung migrations + tao data that trong admin.
- Demo production: import SQL vao database moi/empty.

Copy SQL len EC2:

```bash
scp -i hotel-production-deploy-key hotel_booking_reservation_system.sql ec2-user@YOUR_EC2_ELASTIC_IP:/opt/hotel-booking/
```

Import vao MySQL container:

```bash
ssh -i hotel-production-deploy-key ec2-user@YOUR_EC2_ELASTIC_IP
cd /opt/hotel-booking
docker compose --env-file .env.compose -f docker-compose.prod.yml exec -T db sh -c 'MYSQL_PWD="$MYSQL_PASSWORD" mysql -u"$MYSQL_USER" "$MYSQL_DATABASE"' < hotel_booking_reservation_system.sql
```

Neu import bao loi table da ton tai, dung mot trong hai cach:

- Bo import SQL va su dung data tao moi.
- Reset database volume va import lai tu dau. Chi lam cach nay neu chap nhan mat data hien tai.

Reset database volume la thao tac nguy hiem, nen backup truoc:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml exec -T db sh -c 'MYSQL_PWD="$MYSQL_PASSWORD" mysqldump -u"$MYSQL_USER" "$MYSQL_DATABASE"' > backup-before-reset.sql
```

## 16. Bat HTTPS cho DuckDNS

Chi lam buoc nay sau khi HTTP da chay:

```text
http://hotelhub-demo.duckdns.org
```

Kiem tra Security Group da mo:

```text
80 public
443 public
```

SSH vao EC2:

```bash
ssh -i hotel-production-deploy-key ec2-user@YOUR_EC2_ELASTIC_IP
cd /opt/hotel-booking
```

Xin certificate Let's Encrypt lan dau:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml run --rm certbot certonly --webroot -w /var/www/certbot -d hotelhub-demo.duckdns.org --email your-email@example.com --agree-tos --no-eff-email
```

Neu thanh cong, bat Nginx HTTPS overlay:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml -f docker-compose.duckdns-https.yml up -d nginx
```

Kiem tra log:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml -f docker-compose.duckdns-https.yml logs -f nginx
```

Mo:

```text
https://hotelhub-demo.duckdns.org
```

## 17. Cap nhat PROD_ENV_FILE sau khi HTTPS chay

Khi HTTPS da vao duoc, quay lai GitHub secret `PROD_ENV_FILE` va sua cac dong:

```env
APP_URL=https://hotelhub-demo.duckdns.org
ENABLE_DUCKDNS_HTTPS=true
SESSION_SECURE_COOKIE=true
VNP_RETURN_URL=https://hotelhub-demo.duckdns.org/vnpay-return
```

Giu:

```env
DUCKDNS_DOMAIN=hotelhub-demo.duckdns.org
```

Sau do rerun workflow `CI/CD Production` hoac push commit moi vao `main`/`production`.

Tu lan deploy sau, workflow thay:

```env
ENABLE_DUCKDNS_HTTPS=true
```

nen se tu chay compose voi file overlay:

```bash
docker-compose.duckdns-https.yml
```

## 18. Tao cron renew certificate

Let's Encrypt certificate can renew dinh ky.

Tren EC2:

```bash
cd /opt/hotel-booking
(crontab -l 2>/dev/null; echo "15 3 * * * cd /opt/hotel-booking && docker compose --env-file .env.compose -f docker-compose.prod.yml run --rm certbot renew --quiet && docker compose --env-file .env.compose -f docker-compose.prod.yml -f docker-compose.duckdns-https.yml exec -T nginx nginx -s reload") | crontab -
```

Kiem tra cron:

```bash
crontab -l
```

Test renew khong thuc su cap cert moi:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml run --rm certbot renew --dry-run
```

## 19. Lenh van hanh hang ngay

Vao EC2:

```bash
ssh -i hotel-production-deploy-key ec2-user@YOUR_EC2_ELASTIC_IP
cd /opt/hotel-booking
```

Trang thai services:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml ps
```

Neu HTTPS da bat:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml -f docker-compose.duckdns-https.yml ps
```

Xem log:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml logs -f app
docker compose --env-file .env.compose -f docker-compose.prod.yml logs -f queue
docker compose --env-file .env.compose -f docker-compose.prod.yml logs -f scheduler
docker compose --env-file .env.compose -f docker-compose.prod.yml logs -f nginx
docker compose --env-file .env.compose -f docker-compose.prod.yml logs -f db
```

Chay artisan:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app php artisan about
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app php artisan config:clear
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app php artisan config:cache
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app php artisan view:clear
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app php artisan view:cache
```

Kiem tra dung luong:

```bash
df -h
docker system df
```

Don image cu:

```bash
docker image prune -f
```

## 20. Backup database

Backup tren EC2:

```bash
cd /opt/hotel-booking
docker compose --env-file .env.compose -f docker-compose.prod.yml exec -T db sh -c 'MYSQL_PWD="$MYSQL_PASSWORD" mysqldump -u"$MYSQL_USER" "$MYSQL_DATABASE"' > backup-hotel-$(date +%F-%H%M).sql
```

Tai backup ve may local:

```bash
scp -i hotel-production-deploy-key ec2-user@YOUR_EC2_ELASTIC_IP:/opt/hotel-booking/backup-hotel-YYYY-MM-DD-HHMM.sql .
```

Nen backup truoc khi:

- Import SQL.
- Reset DB volume.
- Deploy thay doi migration lon.
- Nang cap MySQL.

## 21. Rollback

Moi image duoc tag bang commit SHA.

Vao GitHub Actions -> lan deploy cu -> lay image tag, vi du:

```text
ghcr.io/OWNER/REPO-app:OLD_SHA
ghcr.io/OWNER/REPO-nginx:OLD_SHA
```

Tren EC2, rollback HTTP:

```bash
cd /opt/hotel-booking
APP_IMAGE=ghcr.io/OWNER/REPO-app:OLD_SHA NGINX_IMAGE=ghcr.io/OWNER/REPO-nginx:OLD_SHA docker compose --env-file .env.compose -f docker-compose.prod.yml up -d
```

Rollback HTTPS:

```bash
APP_IMAGE=ghcr.io/OWNER/REPO-app:OLD_SHA NGINX_IMAGE=ghcr.io/OWNER/REPO-nginx:OLD_SHA docker compose --env-file .env.compose -f docker-compose.prod.yml -f docker-compose.duckdns-https.yml up -d
```

Sau rollback:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app php artisan config:clear
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app php artisan config:cache
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app php artisan view:cache
```

Neu rollback code sau khi da migrate database len schema moi, co the phat sinh loi do migration khong tu rollback. Backup truoc deploy lon la bat buoc.

## 22. Loi thuong gap va cach sua

### GitHub Actions fail o job Test Laravel

Xem log step:

```text
Run migrations
Run tests
Build frontend
```

Neu fail do test can data, sua test/seed cho phu hop. CI dang dung MySQL service `mysql:8.4`.

### Build image fail

Thuong do:

- `composer.lock` khong khop `composer.json`.
- `package-lock.json` khong khop `package.json`.
- Dependency can extension PHP chua cai trong `Dockerfile`.

Chay local:

```bash
composer install
npm ci
npm run build
```

### Deploy fail vi SSH

Kiem tra secrets:

```text
EC2_HOST
EC2_USER
EC2_SSH_PRIVATE_KEY
```

Kiem tra public key da co trong EC2:

```bash
cat ~/.ssh/authorized_keys
```

### EC2 khong pull duoc image GHCR

Kiem tra:

```text
GHCR_USERNAME
GHCR_TOKEN
```

Tren EC2 co the test:

```bash
echo "YOUR_GHCR_TOKEN" | docker login ghcr.io -u YOUR_GHCR_USERNAME --password-stdin
```

### Website 502 Bad Gateway

Kiem tra app container:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml ps
docker compose --env-file .env.compose -f docker-compose.prod.yml logs -f app
docker compose --env-file .env.compose -f docker-compose.prod.yml logs -f nginx
```

Nguyen nhan hay gap:

- `app` container restart lien tuc.
- `.env.production` thieu bien.
- DB chua healthy.
- Laravel loi bootstrap.

### Laravel loi database

Kiem tra:

```bash
docker compose --env-file .env.compose -f docker-compose.prod.yml logs -f db
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app php artisan migrate:status
```

Trong `.env.production`, DB phai la:

```env
DB_HOST=db
DB_PORT=3306
```

Khong dung `127.0.0.1` trong Docker production.

### Certbot fail challenge

Kiem tra:

- DuckDNS tro dung Elastic IP.
- Port `80` public.
- Container `nginx` dang chay.
- HTTP domain vao duoc truoc khi xin cert.

Test:

```bash
curl -I http://hotelhub-demo.duckdns.org
```

### HTTPS deploy sau do bi mat

Kiem tra secret `PROD_ENV_FILE` da co:

```env
ENABLE_DUCKDNS_HTTPS=true
```

Neu van la `false`, workflow se chay HTTP-only compose.

### Anh upload bi mat sau deploy

Project nay upload vao `public/upload`. Compose da gan volume:

```text
app_public_upload:/var/www/html/public/upload
```

Do do anh upload production nam trong Docker volume, khong nam trong image. Kiem tra:

```bash
docker volume ls
docker compose --env-file .env.compose -f docker-compose.prod.yml exec app ls -la public/upload
```

## 23. Luu y rieng cua project nay

Khong chay:

```bash
php artisan route:cache
```

Ly do: `routes/web.php` hien van co route closure cho `/about` va `/dashboard`. Neu muon dung `route:cache`, hay chuyen cac closure route nay sang controller truoc.

Workflow hien tai chi cache:

```bash
php artisan config:cache
php artisan view:cache
```

## 24. Checklist hoan thanh production

Danh dau tung muc:

```text
[ ] EC2 Amazon Linux 2023 da tao
[ ] Security Group mo 22 cho IP cua minh, 80/443 public
[ ] Elastic IP da gan vao EC2
[ ] Docker va Docker Compose da cai tren EC2
[ ] /opt/hotel-booking da tao va thuoc ec2-user
[ ] Deploy SSH key da tao va test thanh cong
[ ] DuckDNS domain tro dung Elastic IP
[ ] GitHub secrets da tao day du
[ ] PROD_ENV_FILE lan dau dung HTTP va ENABLE_DUCKDNS_HTTPS=false
[ ] Push len dev test xanh
[ ] Merge/push len main hoac production deploy xanh
[ ] http://domain.duckdns.org vao duoc website
[ ] Certbot xin certificate thanh cong
[ ] https://domain.duckdns.org vao duoc website
[ ] PROD_ENV_FILE da doi sang HTTPS va ENABLE_DUCKDNS_HTTPS=true
[ ] Cron renew certificate da tao
[ ] Backup database lan dau da thuc hien
```
