# NSUK Departmental Information Management System (DIMS)

A web-based portal built with **Laravel** for managing departmental information such as announcements, staff profiles, documents, and student feedback at **Nasarawa State University, Keffi (NSUK)**.

---

## 🚀 About the Project

The **Departmental Information Management System (DIMS)** is designed to improve communication and record-keeping in the **Department of Computer Science, NSUK**.

It replaces manual notice boards, WhatsApp groups, and scattered documents with a **centralized platform** where students, staff, and administrators can easily access authentic academic information.

### ✨ Key Features

- 📢 **Announcements** – staff and admins can post departmental updates and memos.
- 👩‍🏫 **Staff Directory** – profiles with position, contact, office hours, and bio.
- 📂 **Document Management** – upload and download timetables, handbooks, syllabi, etc.
- ✉️ **Feedback/Inquiries** – students can submit questions to the department.
- 🔐 **Role-based Access** –
  - **Students** → view announcements, staff directory, documents, send inquiries.
  - **Staff** → manage profile, upload announcements & documents.
  - **Admin/HOD** → full control over staff, announcements, documents, and feedback.

---

## 🛠️ Tech Stack

- **Framework**: [Laravel 12+](https://laravel.com)
- **Frontend**: Blade Templates, TailwindCSS
- **Database**: MySQL / MariaDB
- **Authentication**: Laravel Breeze (role-based access)
- **Optional**: Laravel Notifications (Email/SMS alerts for announcements)

---

## ⚡ Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/nsuk-dims.git
   cd nsuk-dims
   ```
2. Install dependencies:

   ```bash
   composer install
   npm install && npm run build
   ```
3. Configure environment:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Set up database:

   ```bash
   php artisan migrate --seed
   ```
5. Start the server:

   ```bash
   php artisan serve
   ```

Access the app at: **http://127.0.0.1:8000**

---

## 🖥️ User Roles

- 👩‍🎓 **Student**
  - View announcements, staff directory, documents
  - Submit feedback/inquiries
- 👨‍🏫 **Staff**
  - Update profile
  - Upload announcements & documents
- 👨‍💼 **Admin/HOD**
  - Manage staff, announcements, documents, feedback
  - Edit department information (history, mission, vision)

---

## 📬 Contact

For support or inquiries about this project:

**Odafe-Godfrey**
📧 godfreyj.sule1@gmail.com

---

## 📄 License

This project is open-sourced under the [MIT License](https://opensource.org/licenses/MIT).
