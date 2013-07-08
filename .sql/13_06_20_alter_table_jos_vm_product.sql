alter table `jos_vm_product` add column `product_title_tag` varchar(64) NOT NULL;
alter table `jos_vm_product` add column `product_desc_tag` varchar(255) NOT NULL;
alter table `jos_vm_product` add column `product_key_tag` text DEFAULT NULL;
