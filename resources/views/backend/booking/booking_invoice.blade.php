<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Booking Invoice</title>
    <style>
        /* ========== RESET ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1a1a2e;
            background: #ffffff;
        }

        /* ========== HEADER ========== */
        .header-table {
            width: 100%;
            background-color: #1a56db;
            padding: 18px 22px;
            margin-bottom: 18px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .brand-name {
            font-size: 24px;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .brand-sub {
            font-size: 9px;
            color: #bfdbfe;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-top: 3px;
        }

        .company-info {
            text-align: right;
            font-size: 10px;
            color: #dbeafe;
            line-height: 1.9;
        }

        /* ========== META BOXES ========== */
        .meta-table {
            width: 100%;
            margin-bottom: 18px;
            border-collapse: separate;
            border-spacing: 6px 0;
        }

        .meta-box {
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            width: 33%;
        }

        .meta-label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            margin-bottom: 4px;
        }

        .meta-value {
            font-size: 13px;
            font-weight: bold;
            color: #1a1a2e;
        }

        /* ========== SECTION TITLE ========== */
        .section-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }

        /* ========== BOOKING TABLE ========== */
        .booking-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }

        .booking-table thead tr {
            background-color: #1e293b;
            color: #ffffff;
        }

        .booking-table thead th {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            padding: 9px 10px;
            text-align: left;
            color: #ffffff;
        }

        .booking-table tbody td {
            padding: 11px 10px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            color: #1a1a2e;
        }

        .booking-table tbody tr {
            background-color: #ffffff;
        }

        .room-name {
            font-weight: bold;
            font-size: 12px;
            color: #1a56db;
        }

        .room-sub {
            font-size: 9px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .badge {
            display: inline;
            padding: 2px 7px;
            font-size: 9.5px;
            font-weight: bold;
        }

        .badge-in {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .badge-out {
            background-color: #fef3c7;
            color: #92400e;
        }

        .td-right {
            text-align: right;
            font-weight: bold;
        }

        /* ========== SUMMARY SECTION ========== */
        .summary-outer {
            width: 100%;
            margin-bottom: 22px;
        }

        .note-cell {
            width: 52%;
            vertical-align: top;
            padding-right: 14px;
        }

        .totals-cell {
            width: 48%;
            vertical-align: top;
        }

        .note-box {
            background-color: #eff6ff;
            border-left: 3px solid #1a56db;
            padding: 11px 13px;
            font-size: 10.5px;
            color: #1e40af;
            line-height: 1.7;
        }

        .note-box-title {
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 5px;
            display: block;
            color: #1e40af;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
        }

        .totals-table td {
            padding: 7px 10px;
            color: #374151;
        }

        .totals-table .t-right {
            text-align: right;
        }

        .totals-table .row-discount td {
            color: #dc2626;
        }

        .totals-table .row-addon td {
            color: #16a34a;
        }

        .totals-table .row-total {
            background-color: #1a56db;
        }

        .totals-table .row-total td {
            color: #ffffff;
            font-weight: bold;
            font-size: 13px;
            padding: 9px 10px;
        }

        .totals-table .row-divider td {
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }

        /* ========== FOOTER ========== */
        .footer-divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 18px 0 14px;
        }

        .footer-table {
            width: 100%;
        }

        .footer-left {
            vertical-align: bottom;
        }

        .footer-right {
            vertical-align: bottom;
            text-align: right;
        }

        .thank-title {
            font-size: 14px;
            font-weight: bold;
            color: #16a34a;
            margin-bottom: 3px;
        }

        .thank-sub {
            font-size: 9.5px;
            color: #64748b;
            margin-bottom: 7px;
        }

        .confirmed-badge {
            display: inline;
            background-color: #dcfce7;
            color: #15803d;
            font-size: 8.5px;
            font-weight: bold;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 3px 10px;
            border: 1px solid #86efac;
        }

        .sig-line {
            width: 130px;
            border-top: 1.5px solid #1a1a2e;
            margin-bottom: 5px;
        }

        .sig-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #374151;
        }
    </style>
</head>

<body>

    {{-- ══════════════ HEADER ══════════════ --}}
    <table class="header-table" cellpadding="0" cellspacing="0">
        <tr>
            <td width="50%">
                <div class="brand-name">HotelHub</div>
                <div class="brand-sub">Booking Invoice</div>
            </td>
            <td width="50%">
                <div class="company-info">
                    HotelHub Head Office<br>
                    Email: tungvuvanthanh@gmail.com<br>
                    Phone: 0376734165<br>
                    Address: Hưng Yên, Việt Nam
                </div>
            </td>
        </tr>
    </table>

    {{-- ══════════════ META ROW ══════════════ --}}
    <table class="meta-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="meta-box">
                <div class="meta-label">Invoice Number</div>
                <div class="meta-value">{{ $editData->code }}</div>
            </td>
            <td width="6px"></td>
            <td class="meta-box">
                <div class="meta-label">Customer</div>
                <div class="meta-value">{{ $editData->name  }}</div>
            </td>
            <td width="6px"></td>
            <td class="meta-box">
                <div class="meta-label">Booking Date</div>
                <div class="meta-value">{{ \Carbon\Carbon::parse($editData->created_at)->format('d-m-Y') }}</div>
            </td>
        </tr>
    </table>

    {{-- ══════════════ BOOKING TABLE ══════════════ --}}
    <div class="section-title">Booking Details</div>
    <table class="booking-table" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th style="width:22%">Room Type</th>
                <th style="width:9%">Rooms</th>
                <th style="width:13%">Unit Price</th>
                <th style="width:24%">Check-in / Check-out</th>
                <th style="width:12%">Nights</th>
                <th style="width:20%; text-align:right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="room-name">{{ $editData->room->type->name }}</div>
                    <div class="room-sub">Room #{{ $editData->room->id }}</div>
                </td>
                <td>{{ $editData->number_of_rooms }}</td>
                <td>${{ number_format($editData->actual_price, 2) }}</td>
                <td>
                    <span class="badge badge-in">{{ $editData->check_in }}</span>
                    <br><span style="color:#94a3b8;font-size:9px;">&#8595;</span><br>
                    <span class="badge badge-out">{{ $editData->check_out }}</span>
                </td>
                <td>{{ $editData->total_night }} nights</td>
                <td class="td-right">${{ number_format($editData->actual_price * $editData->number_of_rooms, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- ══════════════ SUMMARY ══════════════ --}}
    <table class="summary-outer" cellpadding="0" cellspacing="0">
        <tr>
            <td class="note-cell">
                <div class="note-box">
                    <span class="note-box-title">Note</span>
                    Thank you for choosing HotelHub. Please present this invoice
                    at check-in. For any inquiries, contact our front desk or send us an email.
                </div>
            </td>
            <td class="totals-cell">
                <table class="totals-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>Subtotal</td>
                        <td class="t-right">${{ number_format($editData->subtotal, 0) }}</td>
                    </tr>
                    <tr class="row-discount">
                        <td>Discount</td>
                        <td class="t-right">-${{ number_format($editData->discount, 0) }}</td>
                    </tr>
                    <tr class="row-addon">
                        <td>Add-ons</td>
                        <td class="t-right">+${{ number_format($editData->getAddonFee(), 0) }}</td>
                    </tr>
                    @if ($editData->isDepositPaid())
                        <tr class="row-discount">
                            <td>Deposit ({{ $editData->getDepositPercentage() }}%)</td>
                            <td class="t-right">-${{ number_format($editData->getDepositAmount(), 0) }}</td>
                        </tr>
                        <tr>
                            <td>Balance Due</td>
                            <td class="t-right">${{ number_format($editData->getRemainingAmount(), 0) }}</td>
                        </tr>
                    @endif
                    <tr class="row-divider">
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="row-total">
                        <td>Grand Total</td>
                        <td class="t-right">${{ number_format($editData->total_price, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- ══════════════ FOOTER ══════════════ --}}
    <hr class="footer-divider">
    <table class="footer-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="footer-left">
                <div class="thank-title">Thank you for your booking!</div>
                <div class="thank-sub">We look forward to welcoming you at HotelHub.</div>
                <span class="confirmed-badge">&#10003; Confirmed</span>
            </td>
            <td class="footer-right">
                <div class="sig-label">Authority Signature</div>
            </td>
        </tr>
    </table>

</body>

</html>