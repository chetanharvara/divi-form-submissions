﻿# Divi Form Submissions Viewer (WordPress Plugin)

A lightweight WordPress admin plugin to view, edit, and delete form submissions saved in a custom database table—designed for use with Divi or custom form handlers.

---

## ✨ Features

- View all Divi form submissions in a WP admin page
- Edit form submission entries (name, email, phone, message)
- Delete entries with confirmation
- Secure nonce verification for all actions
- Clean, native WordPress admin UI

## 🛠️ Usage
Once activated:

- Go to Dashboard → Divi Submissions in the WordPress admin panel.
- View all form submissions in a table.
- Click Edit to modify any field.
- Click Delete to remove a submission (with confirmation).
- Submissions are sorted by submitted_at in descending order.

## 📌 Notes
- This plugin assumes you're storing form data in a custom DB table (divi_form_submissions) as a JSON string.
- It does not handle form creation or submission — only views/manages data already stored.

## ✅ Security
- All update/delete actions use WordPress nonces.
- Form fields are sanitized on submission using core WordPress functions.

## 🤝 Contributing
- Pull requests and suggestions are welcome!
- To contribute:
- Fork the repository
- Create a new branch (feature/your-feature)
- Commit your changes
- Open a PR on main

## 📜 License
- This project is licensed under the MIT License.

## 🙋 FAQ
Q: Can I use this without Divi?

A: Yes! As long as your form data is stored in the appropriate table and JSON format.

Q: Can I customize fields?

A: Yes. Just modify the fields inside the plugin’s display and update logic.

## 🔗 Author
Built by Chetan Harvara

Open to feedback and improvements!

---

Let me know if you want a ZIP-ready plugin structure with this `README.md` included, or if you want to add more fields like `Subject`, `Form ID`, or CSV Export functionality.
