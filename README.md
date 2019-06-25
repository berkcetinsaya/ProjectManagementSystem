# Project Management System

This project is to organize and arrange student projects with their professors.

## Usage

When you clone it, put the master folder to your web server directory. Then, import the `projectManagementSystem.sql` file to your mysql database. By default, it will create a new database called as `cdis` with the tables. In case if it does not work, you can use `projectManagementSystemTable.sql` to import only the tables into the database you created. By default, it will only create a student profile. In order to create a professor account, you have to create a user as usual. Then, change `type` to `1`. To enable a project, you have to change `status` to 1 in `project` table.