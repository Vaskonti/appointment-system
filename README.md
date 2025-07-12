# 📅 Appointment Reminder System API

A RESTful API built with Laravel 12 that allows businesses to manage client appointments and send automatic reminders with timezone awareness, recurrence support, and notification preference (email/SMS).

---

## 🧰 Tech Stack

- Laravel 12, PHP 8.2
- Passport (Authentication)
- Horizon + Redis (Queues)
- Mailpit / Mailtrap (Email Testing)
- Vonage / Log (SMS Testing)
- Docker or Laravel Sail compatible

---
## Approach
- **Users** are the so called "businesses" that can create appointments and assign them to clients.
- **Clients** are the users that can receive appointments and reminders.
- **Appointments** can be created with a specific date, time, timezone, and recurrence.
- **Reminders** are sent to clients based on their preferences (email or SMS) and can be customized.
- **Notifications** are sent using Laravel's notification system, allowing for easy customization and extension.
- **Timezone Awareness** ensures that appointments and reminders are sent at the correct local time for each client.
- **Recurrence Support** allows appointments to be set for daily, weekly, or monthly intervals, maximum recurrences and recurrence intervals
- **Notification Preference** allows clients to choose how they want to receive reminders (email or SMS).
- **Testing** is done using Pest, with a focus on API endpoints and business logic as well as unit tests for appointments

## 🌟 Api Documentation
- [Postman Collection](/doc/appointment_system.postman_collection.json)
Please import the Postman collection to test the API endpoints.

## GitHub Actions
- CI/CD pipeline for running Snyk for security vulnerabilities, PHP CodeSniffer fixer, and Pest tests on every push and pull request.

## 🚀 Installation

```bash
git clone https://github.com/Vaskonti/appointment_system.git
cd appointment-reminder-api
cp .env.example .env

# Set DB, Mailtrap, and Vonage credentials
# Configure Redis and Horizon

docker compose up -d --build 
# there is an entrypoint script that will run migrations, seed the database, and start the queue worker
