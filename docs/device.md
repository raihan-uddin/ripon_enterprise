# Devices

Client hardware used with the ERP. Check reports and print layouts against it.

## Mobile printing setup

Users print reports **directly from the browser tab** on the tablet, using the browser's own Print dialog. There is no scale or margin option, and our custom print button isn't used, so a page's `@media print` CSS controls the output.

| Device  | Model                                                                     | Notes |
|---------|---------------------------------------------------------------------------|-------|
| Tablet  | Samsung Galaxy Tab S8 Ultra — model given as **XM-Z900** (Samsung's number is normally **SM-X900**; check Settings → About tablet) | Prints from the mobile browser |
| Printer | **HP Laser 107w**                                                         | A4, **monochrome** laser; tablet prints to it **over Wi-Fi** |

## Print CSS guidelines

- Hide app chrome (navbar, breadcrumb, filters, footer) under `@media print` so only the report prints.
- Nothing should be wider than A4. Otherwise the mobile browser shrinks the whole page to fit, and the text comes out tiny.
- Use large print fonts: about 14–16px for body/table text and 12–13px for headers.
- The printer is black-and-white: colours print as greys. Don't rely on colour alone (e.g. red DR / green CR). Keep text labels.

Reference implementation: `themes/erp/views/report/loanLedger.php` and `loanLedgerView.php`.
