CREATE TABLE "app_config" (
  "key" varchar(50) PRIMARY KEY NOT NULL,
  "value" varchar(500) NOT NULL
);

CREATE TABLE "attribute_definitions" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "name" varchar(255) NOT NULL,
  "type" varchar(45) NOT NULL,
  "unit" varchar(16) DEFAULT null,
  "flags" tinyint(1) NOT NULL,
  "parent_id" int(10) DEFAULT null,
  "deleted" bool NOT NULL DEFAULT false
);

CREATE TABLE "attribute_links" (
  "id" int(11) DEFAULT null,
  "definition_id" int(11) NOT NULL,
  "item_id" int(11) DEFAULT null,
  "sale_id" int(11) DEFAULT null,
  "receiving_id" int(11) DEFAULT null,
  "generated_unique_column" varchar(255)
);

CREATE TABLE "attribute_values" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "value" varchar(255) DEFAULT null,
  "date" date DEFAULT null,
  "decimal" decimal(7,3) DEFAULT null
);

CREATE TABLE "cash_up" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "open_date" timestamp DEFAULT (current_timestamp()),
  "close_date" timestamp DEFAULT null,
  "open_amount_cash" decimal(15,2) NOT NULL,
  "transfer_amount_cash" decimal(15,2) NOT NULL,
  "note" tinyint(4) NOT NULL DEFAULT 0,
  "closed_amount_cash" decimal(15,2) NOT NULL,
  "closed_amount_card" decimal(15,2) NOT NULL,
  "closed_amount_check" decimal(15,2) NOT NULL,
  "closed_amount_total" decimal(15,2) NOT NULL,
  "description" varchar(255) NOT NULL,
  "open_employee_id" int(10) NOT NULL,
  "close_employee_id" int(10) NOT NULL,
  "deleted" tinyint(1) NOT NULL DEFAULT 0,
  "closed_amount_due" decimal(15,2) NOT NULL
);

CREATE TABLE "customers" (
  "person_id" int(10) PRIMARY KEY NOT NULL,
  "company_name" varchar(255) DEFAULT null,
  "account_number" varchar(255) DEFAULT null,
  "taxable" tinyint(1) NOT NULL DEFAULT 1,
  "tax_id" varchar(32) NOT NULL DEFAULT '',
  "sales_tax_code_id" int(11) DEFAULT null,
  "package_id" int(11) DEFAULT null,
  "points" int(11) DEFAULT null,
  "deleted" tinyint(1) NOT NULL DEFAULT 0,
  "discount" decimal(15,2) NOT NULL DEFAULT 0,
  "discount_type" tinyint(1) NOT NULL DEFAULT 0,
  "date" timestamp NOT NULL DEFAULT (current_timestamp()),
  "employee_id" int(10) NOT NULL,
  "consent" tinyint(4) NOT NULL DEFAULT 0
);

CREATE TABLE "customers_packages" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "name" varchar(255) DEFAULT null,
  "points_percent" float NOT NULL DEFAULT 0,
  "deleted" tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE "customers_points" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "person_id" int(11) NOT NULL,
  "package_id" int(11) NOT NULL,
  "sale_id" int(11) NOT NULL,
  "points_earned" int(11) NOT NULL
);

CREATE TABLE "dinner_tables" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "name" varchar(30) NOT NULL,
  "status" tinyint(1) NOT NULL DEFAULT 0,
  "deleted" tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE "employees" (
  "username" varchar(255) NOT NULL,
  "password" varchar(255) NOT NULL,
  "person_id" int(10) PRIMARY KEY NOT NULL,
  "deleted" tinyint(1) NOT NULL DEFAULT 0,
  "hash_version" tinyint(1) NOT NULL DEFAULT 2,
  "language" varchar(48) DEFAULT null,
  "language_code" varchar(8) DEFAULT null
);

CREATE TABLE "expense_categories" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "name" varchar(255) DEFAULT null,
  "description" varchar(255) NOT NULL,
  "deleted" tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE "expenses" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "date" timestamp DEFAULT (current_timestamp()),
  "amount" decimal(15,2) NOT NULL,
  "payment_type" varchar(40) NOT NULL,
  "category_id" int(11) NOT NULL,
  "description" varchar(255) NOT NULL,
  "employee_id" int(10) NOT NULL,
  "deleted" tinyint(1) NOT NULL DEFAULT 0,
  "supplier_tax_code" varchar(255) DEFAULT null,
  "tax_amount" decimal(15,2) DEFAULT null,
  "supplier_id" int(10) DEFAULT null
);

CREATE TABLE "giftcards" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "record_time" timestamp NOT NULL DEFAULT (current_timestamp()),
  "giftcard_number" varchar(255) DEFAULT null,
  "value" decimal(15,2) NOT NULL,
  "deleted" tinyint(1) NOT NULL DEFAULT 0,
  "person_id" int(10) DEFAULT null
);

CREATE TABLE "grants" (
  "permission_id" varchar(255) NOT NULL,
  "employee_id" int(10) NOT NULL,
  "menu_group" varchar(32) DEFAULT 'home',
  PRIMARY KEY ("permission_id", "employee_id")
);

CREATE TABLE "inventory" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "item_id" int(11) NOT NULL DEFAULT 0,
  "user" int(11) NOT NULL DEFAULT 0,
  "date" timestamp NOT NULL DEFAULT (current_timestamp()),
  "comment" text NOT NULL,
  "location_id" int(11) NOT NULL,
  "inventory" decimal(15,3) NOT NULL DEFAULT 0
);

CREATE TABLE "item_kit_items" (
  "id" int(11) NOT NULL,
  "item_kit_id" int(11) NOT NULL,
  "item_id" int(11) NOT NULL,
  "quantity" decimal(15,3) NOT NULL,
  "kit_sequence" int(3) NOT NULL DEFAULT 0,
  PRIMARY KEY ("id", "item_kit_id", "quantity")
);

CREATE TABLE "item_kits" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "item_kit_number" varchar(255) DEFAULT null,
  "name" varchar(255) NOT NULL,
  "description" varchar(255) NOT NULL,
  "item_id" int(10) NOT NULL DEFAULT 0,
  "kit_discount" decimal(15,2) NOT NULL DEFAULT 0,
  "kit_discount_type" tinyint(1) NOT NULL DEFAULT 0,
  "price_option" tinyint(1) NOT NULL DEFAULT 0,
  "print_option" tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE "item_quantities" (
  "item_id" int(11) NOT NULL,
  "location_id" int(11) NOT NULL,
  "quantity" decimal(15,3) NOT NULL DEFAULT 0,
  PRIMARY KEY ("item_id", "location_id")
);

CREATE TABLE "items" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "name" varchar(255) NOT NULL,
  "category" varchar(255) NOT NULL,
  "supplier_id" int(11) DEFAULT null,
  "item_number" varchar(255) DEFAULT null,
  "description" varchar(255) NOT NULL,
  "cost_price" decimal(15,2) NOT NULL,
  "unit_price" decimal(15,2) NOT NULL,
  "reorder_level" decimal(15,3) NOT NULL DEFAULT 0,
  "receiving_quantity" decimal(15,3) NOT NULL DEFAULT 1,
  "pic_filename" varchar(255) DEFAULT null,
  "allow_alt_description" tinyint(1) NOT NULL,
  "is_serialized" tinyint(1) NOT NULL,
  "deleted" tinyint(1) NOT NULL DEFAULT 0,
  "stock_type" tinyint(1) NOT NULL DEFAULT 0,
  "item_type" tinyint(1) NOT NULL DEFAULT 0,
  "tax_category_id" int(10) DEFAULT null,
  "qty_per_pack" decimal(15,3) NOT NULL DEFAULT 1,
  "pack_name" varchar(8) DEFAULT 'Each',
  "low_sell_item_id" int(10) DEFAULT 0,
  "hsn_code" varchar(32) NOT NULL DEFAULT ''
);

CREATE TABLE "items_taxes" (
  "item_id" int(10) NOT NULL,
  "name" varchar(255) NOT NULL,
  "percent" decimal(15,3) NOT NULL,
  PRIMARY KEY ("item_id", "name", "percent")
);

CREATE TABLE "modules" (
  "id" varchar(255) PRIMARY KEY NOT NULL,
  "name_lang_key" varchar(255) NOT NULL,
  "desc_lang_key" varchar(255) NOT NULL,
  "sort" int(10) NOT NULL
);

CREATE TABLE "people" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "first_name" varchar(255) NOT NULL,
  "last_name" varchar(255) NOT NULL,
  "gender" int(1) DEFAULT null,
  "phone_number" varchar(255) NOT NULL,
  "email" varchar(255) NOT NULL,
  "address_1" varchar(255) NOT NULL,
  "address_2" varchar(255) NOT NULL,
  "city" varchar(255) NOT NULL,
  "state" varchar(255) NOT NULL,
  "zip" varchar(255) NOT NULL,
  "country" varchar(255) NOT NULL,
  "comments" text NOT NULL
);

CREATE TABLE "permissions" (
  "id" varchar(255) PRIMARY KEY NOT NULL,
  "module_id" varchar(255) NOT NULL,
  "location_id" int(10) DEFAULT null
);

CREATE TABLE "receivings" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "time" timestamp NOT NULL DEFAULT (current_timestamp()),
  "supplier_id" int(10) DEFAULT null,
  "employee_id" int(10) NOT NULL DEFAULT 0,
  "comment" text NOT NULL,
  "payment_type" varchar(20) DEFAULT null,
  "reference" varchar(32) DEFAULT null
);

CREATE TABLE "receivings_items" (
  "receiving_id" int(10) NOT NULL DEFAULT 0,
  "item_id" int(10) NOT NULL DEFAULT 0,
  "description" varchar(30) DEFAULT null,
  "serialnumber" varchar(30) DEFAULT null,
  "line" int(3) NOT NULL,
  "quantity_purchased" decimal(15,3) NOT NULL DEFAULT 0,
  "item_cost_price" decimal(15,2) NOT NULL,
  "item_unit_price" decimal(15,2) NOT NULL,
  "discount" decimal(15,2) NOT NULL DEFAULT 0,
  "discount_type" tinyint(1) NOT NULL DEFAULT 0,
  "item_location" int(11) NOT NULL,
  "receiving_quantity" decimal(15,3) NOT NULL DEFAULT 1,
  PRIMARY KEY ("receiving_id", "item_id", "line")
);

CREATE TABLE "sales" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "time" timestamp NOT NULL DEFAULT (current_timestamp()),
  "customer_id" int(10) DEFAULT null,
  "employee_id" int(10) NOT NULL DEFAULT 0,
  "comment" text NOT NULL,
  "invoice_number" varchar(32) DEFAULT null,
  "dinner_table_id" int(11) DEFAULT null,
  "quote_number" varchar(32) DEFAULT null,
  "sale_status" tinyint(1) NOT NULL DEFAULT 0,
  "work_order_number" varchar(32) DEFAULT null,
  "sale_type" tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE "sales_items" (
  "sale_id" int(10) NOT NULL DEFAULT 0,
  "item_id" int(10) NOT NULL DEFAULT 0,
  "description" varchar(255) DEFAULT null,
  "serialnumber" varchar(30) DEFAULT null,
  "line" int(3) NOT NULL DEFAULT 0,
  "quantity_purchased" decimal(15,3) NOT NULL DEFAULT 0,
  "item_cost_price" decimal(15,2) NOT NULL,
  "item_unit_price" decimal(15,2) NOT NULL,
  "discount" decimal(15,2) NOT NULL DEFAULT 0,
  "discount_type" tinyint(1) NOT NULL DEFAULT 0,
  "item_location_id" int(11) NOT NULL,
  "print_option" tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY ("sale_id", "item_id", "line")
);

CREATE TABLE "sales_items_taxes" (
  "sale_id" int(10) NOT NULL,
  "item_id" int(10) NOT NULL,
  "line" int(3) NOT NULL DEFAULT 0,
  "name" varchar(255) NOT NULL,
  "percent" decimal(15,4) NOT NULL DEFAULT 0,
  "tax_type" tinyint(1) NOT NULL DEFAULT 0,
  "rounding_code" tinyint(1) NOT NULL DEFAULT 0,
  "cascade_sequence" tinyint(1) NOT NULL DEFAULT 0,
  "item_tax_amount" decimal(15,4) NOT NULL DEFAULT 0,
  "sales_tax_code_id" int(11) DEFAULT null,
  "jurisdiction_id" int(11) DEFAULT null,
  "tax_category_id" int(11) DEFAULT null,
  PRIMARY KEY ("sale_id", "item_id", "line", "name", "percent")
);

CREATE TABLE "sales_payments" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "sale_id" int(10) NOT NULL,
  "type" varchar(40) NOT NULL,
  "amount" decimal(15,2) NOT NULL,
  "cash_refund" decimal(15,2) NOT NULL DEFAULT 0,
  "cash_adjustment" tinyint(4) NOT NULL DEFAULT 0,
  "employee_id" int(11) DEFAULT null,
  "time" timestamp NOT NULL DEFAULT (current_timestamp()),
  "reference_code" varchar(40) NOT NULL DEFAULT ''
);

CREATE TABLE "sales_reward_points" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "sale_id" int(11) NOT NULL,
  "earned" float NOT NULL,
  "used" float NOT NULL
);

CREATE TABLE "sales_taxes" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "sale_id" int(10) NOT NULL,
  "jurisdiction_id" int(11) DEFAULT null,
  "tax_category_id" int(11) DEFAULT null,
  "tax_type" smallint(2) NOT NULL,
  "tax_group" varchar(32) NOT NULL,
  "sale_tax_basis" decimal(15,4) NOT NULL,
  "sale_tax_amount" decimal(15,4) NOT NULL,
  "print_sequence" tinyint(1) NOT NULL DEFAULT 0,
  "name" varchar(255) NOT NULL,
  "tax_rate" decimal(15,4) NOT NULL,
  "sales_tax_code_id" int(11) DEFAULT null,
  "rounding_code" tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE "stock_locations" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "location_name" varchar(255) DEFAULT null,
  "deleted" tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE "suppliers" (
  "person_id" int(10) PRIMARY KEY NOT NULL,
  "company_name" varchar(255) NOT NULL,
  "agency_name" varchar(255) NOT NULL,
  "account_number" varchar(255) DEFAULT null,
  "tax_id" varchar(32) NOT NULL DEFAULT '',
  "deleted" tinyint(1) NOT NULL DEFAULT 0,
  "category" tinyint(1) NOT NULL
);

CREATE TABLE "tax_categories" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "category" varchar(32) NOT NULL,
  "group_sequence" tinyint(1) NOT NULL,
  "deleted" tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE "tax_codes" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "code" varchar(32) NOT NULL,
  "code_name" varchar(255) NOT NULL DEFAULT '',
  "city" varchar(255) NOT NULL DEFAULT '',
  "state" varchar(255) NOT NULL DEFAULT '',
  "deleted" tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE "tax_jurisdictions" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "name" varchar(255) DEFAULT null,
  "tax_group" varchar(32) NOT NULL,
  "tax_type" smallint(2) NOT NULL,
  "reporting_authority" varchar(255) DEFAULT null,
  "tax_group_sequence" tinyint(1) NOT NULL DEFAULT 0,
  "cascade_sequence" tinyint(1) NOT NULL DEFAULT 0,
  "deleted" tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE "tax_rates" (
  "id" SERIAL PRIMARY KEY NOT NULL,
  "tax_code_id" int(11) NOT NULL,
  "tax_category_id" int(10) NOT NULL,
  "jurisdiction_id" int(11) NOT NULL,
  "rate" decimal(15,4) NOT NULL DEFAULT 0,
  "rounding_code" tinyint(1) NOT NULL DEFAULT 0
);

CREATE INDEX "fk_parent_id" ON "attribute_definitions" ("parent_id");

CREATE INDEX "attribute_definitions_name" ON "attribute_definitions" ("name");

CREATE INDEX "attribute_definitions_type" ON "attribute_definitions" ("type");

CREATE UNIQUE INDEX "attribute_links_uq1" ON "attribute_links" ("id", "definition_id", "item_id", "sale_id", "receiving_id");

CREATE UNIQUE INDEX "attribute_links_uq2" ON "attribute_links" ("item_id", "receiving_id", "sale_id", "definition_id", "id");

CREATE UNIQUE INDEX "attribute_links_uq3" ON "attribute_links" ("generated_unique_column");

CREATE INDEX "attribute_links_id" ON "attribute_links" ("id");

CREATE INDEX "attribute_links_definition_id" ON "attribute_links" ("definition_id");

CREATE INDEX "attribute_links_item_id" ON "attribute_links" ("item_id");

CREATE INDEX "attribute_links_sale_id" ON "attribute_links" ("sale_id");

CREATE INDEX "attribute_links_receiving_id" ON "attribute_links" ("receiving_id");

CREATE UNIQUE INDEX "attribute_values_value" ON "attribute_values" ("value");

CREATE UNIQUE INDEX "attribute_values_date" ON "attribute_values" ("date");

CREATE UNIQUE INDEX "attribute_values_decimal" ON "attribute_values" ("decimal");

CREATE INDEX "cash_up_open_employee_id" ON "cash_up" ("open_employee_id");

CREATE INDEX "cash_up_close_employee_id" ON "cash_up" ("close_employee_id");

CREATE INDEX "customers_package_id" ON "customers" ("package_id");

CREATE INDEX "customers_sales_tax_code_id" ON "customers" ("sales_tax_code_id");

CREATE INDEX "customers_account_number" ON "customers" ("account_number");

CREATE INDEX "customers_company_name" ON "customers" ("company_name");

CREATE INDEX "customers_points_person_id" ON "customers_points" ("person_id");

CREATE INDEX "customers_points_package_id" ON "customers_points" ("package_id");

CREATE INDEX "customers_points_sale_id" ON "customers_points" ("sale_id");

CREATE INDEX "dinner_tables_status" ON "dinner_tables" ("status");

CREATE UNIQUE INDEX "employees_username" ON "employees" ("username");

CREATE UNIQUE INDEX "expense_categories_name" ON "expense_categories" ("name");

CREATE INDEX "expense_categories_description" ON "expense_categories" ("description");

CREATE INDEX "expenses_category_id" ON "expenses" ("category_id");

CREATE INDEX "expenses_employee_id" ON "expenses" ("employee_id");

CREATE INDEX "expenses_date" ON "expenses" ("date");

CREATE INDEX "expenses_payment_type" ON "expenses" ("payment_type");

CREATE INDEX "expenses_amount" ON "expenses" ("amount");

CREATE INDEX "expenses_supplier_id" ON "expenses" ("supplier_id");

CREATE UNIQUE INDEX "giftcards_giftcard_number" ON "giftcards" ("giftcard_number");

CREATE INDEX "giftcards_person_id" ON "giftcards" ("person_id");

CREATE INDEX "grants_employee_id" ON "grants" ("employee_id");

CREATE INDEX "inventory_item_id" ON "inventory" ("item_id");

CREATE INDEX "inventory_user" ON "inventory" ("user");

CREATE INDEX "inventory_location_id" ON "inventory" ("location_id");

CREATE INDEX "inventory_date" ON "inventory" ("date");

CREATE INDEX "inventory_item_id_date" ON "inventory" ("item_id", "date");

CREATE INDEX "item_kit_items_item_kit_id" ON "item_kit_items" ("item_kit_id");

CREATE INDEX "item_kit_items_item_id" ON "item_kit_items" ("item_id");

CREATE INDEX "item_kit_number" ON "item_kits" ("item_kit_number");

CREATE INDEX "name" ON "item_kits" ("name", "description");

CREATE INDEX "item_id" ON "item_quantities" ("item_id");

CREATE INDEX "location_id" ON "item_quantities" ("location_id");

CREATE UNIQUE INDEX "items_uq1" ON "items" ("supplier_id", "id", "deleted", "item_type");

CREATE INDEX "item_supplier_id" ON "items" ("supplier_id");

CREATE INDEX "item_number" ON "items" ("item_number");

CREATE INDEX "deleted" ON "items" ("deleted", "item_type");

CREATE INDEX "item_id_deleted" ON "items" ("id", "deleted");

CREATE UNIQUE INDEX "modules_desc_lang_key" ON "modules" ("desc_lang_key");

CREATE UNIQUE INDEX "modules_name_lang_key" ON "modules" ("name_lang_key");

CREATE INDEX "people_email" ON "people" ("email");

CREATE INDEX "people_names_email_phone_number" ON "people" ("first_name", "last_name", "email", "phone_number");

CREATE INDEX "permissions_module_id" ON "permissions" ("module_id");

CREATE INDEX "permissions_location_id" ON "permissions" ("location_id");

CREATE INDEX "receivings_supplier_id" ON "receivings" ("supplier_id");

CREATE INDEX "receivings_employee_id" ON "receivings" ("employee_id");

CREATE INDEX "receivings_reference" ON "receivings" ("reference");

CREATE INDEX "receivings_time" ON "receivings" ("time");

CREATE INDEX "receiving_items_item_id" ON "receivings_items" ("item_id");

CREATE UNIQUE INDEX "sales_invoice_number" ON "sales" ("invoice_number");

CREATE INDEX "sales_customer_id" ON "sales" ("customer_id");

CREATE INDEX "sales_employee_id" ON "sales" ("employee_id");

CREATE INDEX "sales_time" ON "sales" ("time");

CREATE INDEX "sales_dinner_table_id" ON "sales" ("dinner_table_id");

CREATE INDEX "sales_items_sale_id" ON "sales_items" ("sale_id");

CREATE INDEX "sales_items_item_id" ON "sales_items" ("item_id");

CREATE INDEX "sales_items_item_location_id" ON "sales_items" ("item_location_id");

CREATE INDEX "sales_items_taxes_sale_id" ON "sales_items_taxes" ("sale_id");

CREATE INDEX "sales_items_taxes_item_id" ON "sales_items_taxes" ("item_id");

CREATE INDEX "payment_sale" ON "sales_payments" ("sale_id", "type");

CREATE INDEX "sales_payments_employee_id" ON "sales_payments" ("employee_id");

CREATE INDEX "sales_payments_time" ON "sales_payments" ("time");

CREATE INDEX "sale_id" ON "sales_reward_points" ("sale_id");

CREATE INDEX "sales_taxes_print_sequence" ON "sales_taxes" ("sale_id", "print_sequence", "tax_group");

CREATE UNIQUE INDEX "suppliers_account_number" ON "suppliers" ("account_number");

CREATE INDEX "suppliers_category" ON "suppliers" ("category");

CREATE INDEX "suppliers_company_name" ON "suppliers" ("company_name", "deleted");

CREATE UNIQUE INDEX "tax_jurisdictions_tax_group" ON "tax_jurisdictions" ("tax_group");

CREATE INDEX "tax_rate_tax_category_id" ON "tax_rates" ("tax_category_id");

CREATE INDEX "tax_rate_tax_code_id" ON "tax_rates" ("tax_code_id");

CREATE INDEX "tax_rate_jurisdiction_id" ON "tax_rates" ("jurisdiction_id");

ALTER TABLE "attribute_definitions" ADD CONSTRAINT "fk_attribute_definitions_parent_id" FOREIGN KEY ("parent_id") REFERENCES "attribute_definitions" ("id");

ALTER TABLE "attribute_links" ADD CONSTRAINT "fk_attribute_links_definition_id" FOREIGN KEY ("definition_id") REFERENCES "attribute_definitions" ("id");

ALTER TABLE "attribute_links" ADD CONSTRAINT "fk_attribute_links_attribute_id" FOREIGN KEY ("id") REFERENCES "attribute_values" ("id");

ALTER TABLE "attribute_links" ADD CONSTRAINT "fk_attribute_links_item_id" FOREIGN KEY ("item_id") REFERENCES "items" ("id");

ALTER TABLE "attribute_links" ADD CONSTRAINT "fk_attribute_links_receiving_id" FOREIGN KEY ("receiving_id") REFERENCES "receivings" ("id");

ALTER TABLE "attribute_links" ADD CONSTRAINT "fk_attribute_links_sale_id" FOREIGN KEY ("sale_id") REFERENCES "sales" ("id");

ALTER TABLE "cash_up" ADD CONSTRAINT "fk_cash_up_open_employee_id" FOREIGN KEY ("open_employee_id") REFERENCES "employees" ("person_id");

ALTER TABLE "cash_up" ADD CONSTRAINT "fk_cash_up_close_employee_id" FOREIGN KEY ("close_employee_id") REFERENCES "employees" ("person_id");

ALTER TABLE "customers" ADD CONSTRAINT "fk_customers_person_id" FOREIGN KEY ("person_id") REFERENCES "people" ("id");

ALTER TABLE "customers" ADD CONSTRAINT "fk_customers_package_id" FOREIGN KEY ("package_id") REFERENCES "customers_packages" ("id");

ALTER TABLE "customers" ADD CONSTRAINT "fk_customers_sales_tax_code_id" FOREIGN KEY ("sales_tax_code_id") REFERENCES "tax_codes" ("id");

ALTER TABLE "customers_points" ADD CONSTRAINT "fk_customers_points_person_id" FOREIGN KEY ("person_id") REFERENCES "customers" ("person_id");

ALTER TABLE "customers_points" ADD CONSTRAINT "fk_customers_points_package_id" FOREIGN KEY ("package_id") REFERENCES "customers_packages" ("id");

ALTER TABLE "customers_points" ADD CONSTRAINT "fk_customers_points_sale_id" FOREIGN KEY ("sale_id") REFERENCES "sales" ("id");

ALTER TABLE "employees" ADD CONSTRAINT "fk_employees_person_id" FOREIGN KEY ("person_id") REFERENCES "people" ("id");

ALTER TABLE "expenses" ADD CONSTRAINT "fk_expenses_expense_category_id" FOREIGN KEY ("category_id") REFERENCES "expense_categories" ("id");

ALTER TABLE "expenses" ADD CONSTRAINT "fk_expenses_employee_id" FOREIGN KEY ("employee_id") REFERENCES "employees" ("person_id");

ALTER TABLE "expenses" ADD CONSTRAINT "fk_expenses_supplier_id" FOREIGN KEY ("supplier_id") REFERENCES "suppliers" ("person_id");

ALTER TABLE "giftcards" ADD CONSTRAINT "fk_giftcards_person_id" FOREIGN KEY ("person_id") REFERENCES "people" ("id");

ALTER TABLE "grants" ADD CONSTRAINT "fk_grants_permission_id" FOREIGN KEY ("permission_id") REFERENCES "permissions" ("id") ON DELETE CASCADE;

ALTER TABLE "grants" ADD CONSTRAINT "fk_grants_employee_id" FOREIGN KEY ("employee_id") REFERENCES "employees" ("person_id") ON DELETE CASCADE;

ALTER TABLE "inventory" ADD CONSTRAINT "fk_inventory_item_id" FOREIGN KEY ("item_id") REFERENCES "items" ("id");

ALTER TABLE "inventory" ADD CONSTRAINT "fk_inventory_user" FOREIGN KEY ("user") REFERENCES "employees" ("person_id");

ALTER TABLE "inventory" ADD CONSTRAINT "fk_inventory_location_id" FOREIGN KEY ("location_id") REFERENCES "stock_locations" ("id");

ALTER TABLE "item_kit_items" ADD CONSTRAINT "fk_item_kit_items_item_kit_id" FOREIGN KEY ("item_kit_id") REFERENCES "item_kits" ("id") ON DELETE CASCADE;

ALTER TABLE "item_kit_items" ADD CONSTRAINT "fk_item_kit_items_item_id" FOREIGN KEY ("item_id") REFERENCES "items" ("id") ON DELETE CASCADE;

ALTER TABLE "item_quantities" ADD CONSTRAINT "fk_item_quantities_item_id" FOREIGN KEY ("item_id") REFERENCES "items" ("id");

ALTER TABLE "item_quantities" ADD CONSTRAINT "fk_item_quantities_location_id" FOREIGN KEY ("location_id") REFERENCES "stock_locations" ("id");

ALTER TABLE "items" ADD CONSTRAINT "fk_items_supplier_id" FOREIGN KEY ("supplier_id") REFERENCES "suppliers" ("person_id");

ALTER TABLE "items_taxes" ADD CONSTRAINT "fk_items_taxes_item_id" FOREIGN KEY ("item_id") REFERENCES "items" ("id") ON DELETE CASCADE;

ALTER TABLE "permissions" ADD CONSTRAINT "fk_permissions_module_id" FOREIGN KEY ("module_id") REFERENCES "modules" ("id") ON DELETE CASCADE;

ALTER TABLE "permissions" ADD CONSTRAINT "fk_permissions_location_id" FOREIGN KEY ("location_id") REFERENCES "stock_locations" ("id") ON DELETE CASCADE;

ALTER TABLE "receivings" ADD CONSTRAINT "fk_receivings_employee_id" FOREIGN KEY ("employee_id") REFERENCES "employees" ("person_id");

ALTER TABLE "receivings" ADD CONSTRAINT "fk_receivings_supplier_id" FOREIGN KEY ("supplier_id") REFERENCES "suppliers" ("person_id");

ALTER TABLE "receivings_items" ADD CONSTRAINT "fk_receivings_items_item_id" FOREIGN KEY ("item_id") REFERENCES "items" ("id");

ALTER TABLE "receivings_items" ADD CONSTRAINT "fk_receivings_items_receiving_id" FOREIGN KEY ("receiving_id") REFERENCES "receivings" ("id");

ALTER TABLE "sales" ADD CONSTRAINT "fk_sales_employee_id" FOREIGN KEY ("employee_id") REFERENCES "employees" ("person_id");

ALTER TABLE "sales" ADD CONSTRAINT "fk_sales_customer_id" FOREIGN KEY ("customer_id") REFERENCES "customers" ("person_id");

ALTER TABLE "sales" ADD CONSTRAINT "fk_sales_dinner_table_id" FOREIGN KEY ("dinner_table_id") REFERENCES "dinner_tables" ("id");

ALTER TABLE "sales_items" ADD CONSTRAINT "fk_sales_items_item_id" FOREIGN KEY ("item_id") REFERENCES "items" ("id");

ALTER TABLE "sales_items" ADD CONSTRAINT "fk_sales_items_sale_id" FOREIGN KEY ("sale_id") REFERENCES "sales" ("id");

ALTER TABLE "sales_items" ADD CONSTRAINT "fk_sales_items_location_id" FOREIGN KEY ("item_location_id") REFERENCES "stock_locations" ("id");

ALTER TABLE "sales_items_taxes" ADD CONSTRAINT "fk_sales_items_taxes_combined" FOREIGN KEY ("sale_id", "item_id", "line") REFERENCES "sales_items" ("sale_id", "item_id", "line");

ALTER TABLE "sales_items_taxes" ADD CONSTRAINT "fk_sales_items_taxes_item_id" FOREIGN KEY ("item_id") REFERENCES "items" ("id");

ALTER TABLE "sales_payments" ADD CONSTRAINT "fk_sales_payments_sale_id" FOREIGN KEY ("sale_id") REFERENCES "sales" ("id");

ALTER TABLE "sales_payments" ADD CONSTRAINT "fk_sales_payments_employee_id" FOREIGN KEY ("employee_id") REFERENCES "employees" ("person_id");

ALTER TABLE "sales_reward_points" ADD CONSTRAINT "fk_sales_reward_points_sale_id" FOREIGN KEY ("sale_id") REFERENCES "sales" ("id");

ALTER TABLE "suppliers" ADD CONSTRAINT "fk_suppliers_person_id" FOREIGN KEY ("person_id") REFERENCES "people" ("id");

ALTER TABLE "tax_rates" ADD CONSTRAINT "fk_tax_rates_tax_category_id" FOREIGN KEY ("tax_category_id") REFERENCES "tax_categories" ("id");

ALTER TABLE "tax_rates" ADD CONSTRAINT "fk_tax_rates_tax_code_id" FOREIGN KEY ("tax_code_id") REFERENCES "tax_codes" ("id");

ALTER TABLE "tax_rates" ADD CONSTRAINT "fk_tax_rates_jurisdiction_id" FOREIGN KEY ("jurisdiction_id") REFERENCES "tax_jurisdictions" ("id");
