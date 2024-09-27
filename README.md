# To-Do Task Application

## Overview
This is a To-Do Task Application built using Laravel and Vue.js. The application allows users to manage tasks and categories efficiently.

## Features

- **User Authentication**
    - Registration and login functionality to manage user accounts.

- **Category Management**
    - Create, read, update, and delete categories.
    - Display a list of categories with assigned task counts.

- **Task Management**
    - Create, read, update, and delete tasks.
    - Assign tasks to specific categories.

- **Task Filtering**
    - Filter tasks by category for easier management.

- **Task Completion Toggle**
    - Toggle button to mark tasks as completed.

- **Progress Tracking**
    - Visual progress bar showing the percentage of completed tasks.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/parthkapatel/ToDoList.git
2. Navigate to the project directory:
    ```bash
   cd ToDoList
3. Install PHP Dependencies
   ```bash
   composer install
4. Install Node.js Dependencies
   ```bash
   npm install
5. Set Up the Environment File
    ```bash
   cp .env.example .env
6. Generate the Application Key
   ```bash
   php artisan key:generate
7. Migrate the Database
   ```bash
   php artisan migrate   
8. Compile Assets
   ```bash
   npm run dev
9. Run the Application
   ```bash
   php artisan serve

