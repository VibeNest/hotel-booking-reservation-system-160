# Admin Permissions List

Danh sách tất cả các quyền (permissions) trong hệ thống Admin, được phân loại theo từng nhóm chức năng (group).

---

## 1. Dashboard

| #   | Permission Name  | Description          |
| --- | ---------------- | -------------------- |
| 1   | `dashboard.view` | View admin dashboard |

---

## 2. Teams Management

| #   | Permission Name | Description                    |
| --- | --------------- | ------------------------------ |
| 1   | `team.view`     | View all teams / list teams    |
| 2   | `team.create`   | Create / add a new team member |
| 3   | `team.edit`     | Edit an existing team member   |
| 4   | `team.update`   | Update team member details     |
| 5   | `team.delete`   | Delete a team member           |

---

## 3. Testimonial Management

| #   | Permission Name      | Description                    |
| --- | -------------------- | ------------------------------ |
| 1   | `testimonial.view`   | View all testimonials          |
| 2   | `testimonial.create` | Create / add a new testimonial |
| 3   | `testimonial.edit`   | Edit an existing testimonial   |
| 4   | `testimonial.update` | Update testimonial details     |
| 5   | `testimonial.delete` | Delete a testimonial           |

---

## 4. Blog

| #   | Permission Name        | Description                |
| --- | ---------------------- | -------------------------- |
| 1   | `blog.category.view`   | View blog categories       |
| 2   | `blog.category.create` | Create a new blog category |
| 3   | `blog.category.edit`   | Edit a blog category       |
| 4   | `blog.category.delete` | Delete a blog category     |
| 5   | `blog.post.view`       | View all blog posts        |
| 6   | `blog.post.create`     | Create a new blog post     |
| 7   | `blog.post.edit`       | Edit a blog post           |
| 8   | `blog.post.delete`     | Delete a blog post         |

---

## 5. Comment Management

| #   | Permission Name   | Description                 |
| --- | ----------------- | --------------------------- |
| 1   | `comment.view`    | View all comments           |
| 2   | `comment.approve` | Approve / publish a comment |
| 3   | `comment.reply`   | Reply to a comment          |
| 4   | `comment.delete`  | Delete a comment            |

---

## 6. Book Area Management

| #   | Permission Name    | Description                  |
| --- | ------------------ | ---------------------------- |
| 1   | `book.area.view`   | View all book areas          |
| 2   | `book.area.create` | Create / add a new book area |
| 3   | `book.area.edit`   | Edit an existing book area   |
| 4   | `book.area.update` | Update book area details     |
| 5   | `book.area.delete` | Delete a book area           |

---

## 7. Hotel Gallery

| #   | Permission Name  | Description                |
| --- | ---------------- | -------------------------- |
| 1   | `gallery.view`   | View all gallery images    |
| 2   | `gallery.create` | Add a new gallery image    |
| 3   | `gallery.edit`   | Edit gallery image details |
| 4   | `gallery.delete` | Delete a gallery image     |

---

## 8. Room Type Management

| #   | Permission Name    | Description                  |
| --- | ------------------ | ---------------------------- |
| 1   | `room.type.view`   | View all room types          |
| 2   | `room.type.create` | Create / add a new room type |
| 3   | `room.type.edit`   | Edit an existing room type   |
| 4   | `room.type.update` | Update room type details     |
| 5   | `room.type.delete` | Delete a room type           |

---

## 9. Booking

| #   | Permission Name  | Description                      |
| --- | ---------------- | -------------------------------- |
| 1   | `booking.view`   | View all bookings / booking list |
| 2   | `booking.create` | Create / add a new booking       |
| 3   | `booking.edit`   | Edit an existing booking         |
| 4   | `booking.update` | Update booking details / status  |
| 5   | `booking.delete` | Delete a booking                 |
| 6   | `booking.detail` | View booking details             |

---

## 10. Room List Management

| #   | Permission Name    | Description                 |
| --- | ------------------ | --------------------------- |
| 1   | `room.list.view`   | View all available rooms    |
| 2   | `room.list.create` | Add a new room to the list  |
| 3   | `room.list.edit`   | Edit room details           |
| 4   | `room.list.update` | Update room information     |
| 5   | `room.list.delete` | Delete a room from the list |

---

## 11. Booking Report

| #   | Permission Name         | Description                          |
| --- | ----------------------- | ------------------------------------ |
| 1   | `booking.report.view`   | View booking reports                 |
| 2   | `booking.report.export` | Export booking reports (PDF / Excel) |
| 3   | `booking.report.filter` | Filter / search booking reports      |

---

## 12. Role and Permission

| #   | Permission Name     | Description                  |
| --- | ------------------- | ---------------------------- |
| 1   | `permission.view`   | View all permissions         |
| 2   | `permission.create` | Create a new permission      |
| 3   | `permission.edit`   | Edit an existing permission  |
| 4   | `permission.delete` | Delete a permission          |
| 5   | `role.view`         | View all roles               |
| 6   | `role.create`       | Create a new role            |
| 7   | `role.edit`         | Edit an existing role        |
| 8   | `role.delete`       | Delete a role                |
| 9   | `role.assign`       | Assign permissions to a role |

---

## 13. Contact

| #   | Permission Name          | Description                  |
| --- | ------------------------ | ---------------------------- |
| 1   | `contact.message.view`   | View all contact messages    |
| 2   | `contact.message.detail` | View contact message details |
| 3   | `contact.message.reply`  | Reply to a contact message   |
| 4   | `contact.message.delete` | Delete a contact message     |

---

## 14. Setting

| #   | Permission Name       | Description                             |
| --- | --------------------- | --------------------------------------- |
| 1   | `smtp.setting.view`   | View SMTP configuration                 |
| 2   | `smtp.setting.update` | Update SMTP configuration               |
| 3   | `site.setting.view`   | View site settings                      |
| 4   | `site.setting.update` | Update site settings (logo, info, etc.) |

---

## Summary by Group

| Group Name             | Total Permissions |
| ---------------------- | :---------------: |
| Dashboard              |         1         |
| Teams Management       |         5         |
| Testimonial Management |         5         |
| Blog                   |         8         |
| Comment Management     |         4         |
| Book Area Management   |         5         |
| Hotel Gallery          |         4         |
| Room Type Management   |         5         |
| Booking                |         6         |
| Room List Management   |         5         |
| Booking Report         |         3         |
| Role and Permission    |         9         |
| Contact                |         4         |
| Setting                |         4         |
| **TOTAL**              |      **68**       |
