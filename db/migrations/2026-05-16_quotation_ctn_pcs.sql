-- Quotation Ctn + Pcs support
-- Branch: quotation-ctn-pcs
-- Run once against the application database (default: ripon_ent).

-- 1) Pack size on the product master.
ALTER TABLE prod_models
    ADD COLUMN pcs_per_ctn INT NOT NULL DEFAULT 1
    AFTER unit_id;

-- 2) Split ctn / pcs entry on quotation detail rows.
--    `qty` stays as the canonical decimal source of truth for all downstream
--    calculations (preview, totals, sync). Server recomputes it from ctn/pcs/ppc.
ALTER TABLE sell_order_quotation_details
    ADD COLUMN ctn_qty INT NOT NULL DEFAULT 0 AFTER qty,
    ADD COLUMN pcs_qty INT NOT NULL DEFAULT 0 AFTER ctn_qty;
