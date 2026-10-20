-- Membuat database inventory
/* CREATE DATABASE InventoryTokoListrik;
GO */

-- Membuat login SQL Server untuk aplikasi
-- Ganti password dengan password yang kuat
/* USE master;
GO */

/* CREATE LOGIN inventory_app
WITH PASSWORD = 'lighttools';
GO */

USE InventoryTokoListrik;

/* CREATE USER inventory_app FOR LOGIN inventory_app;
GO */

/*ALTER ROLE db_datareader ADD MEMBER inventory_app;
ALTER ROLE db_datawriter ADD MEMBER inventory_app;
GO */

ALTER ROLE db_owner ADD MEMBER inventory_app;
GO