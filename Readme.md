Api documentation: https://wabzafakhouya-4069806.postman.co/workspace/6ecbe70f-7cfa-494b-8067-d3698e981547/documentation/53176850-cae50c81-daee-46e8-832f-a8ec933cb719

⚡ EV Charging Station Reservation System

A RESTful backend system that manages electric vehicle charging station reservations.
The platform allows users to search for charging stations, book time slots, modify or cancel reservations, while administrators manage infrastructure and monitor system statistics.

The project is built using Laravel and implements modern backend practices such as token authentication, background jobs, and automated reservation lifecycle management.

📌 Project Purpose

The objective of this project is to simulate a smart EV charging infrastructure backend capable of:

Managing charging stations

Handling reservations

Preventing reservation conflicts

Automatically updating station availability

Providing operational statistics for administrators

The system is designed to support real-time reservation workflows while maintaining data integrity and automation through background processing.

🏗️ System Architecture

The application follows a typical RESTful backend architecture based on the MVC pattern provided by Laravel.

Main components:

Controllers
│
├── Authentication Controller
├── Station Controller
├── Reservation Controller
└── Statistics Controller

Models
│
├── User
├── Station
├── ConnectorType
└── Reservation

Background Processing
│
├── StartChargingJob
└── CompleteReservationJob

The architecture ensures clear separation of responsibilities between:

Controllers → request handling

Models → database interaction

Jobs → asynchronous operations

Middleware → access control

🧰 Tech Stack

Backend framework:

Laravel

Authentication:

Laravel Sanctum

Testing:

Pest PHP

Database:

Postgres

Background Processing:

Laravel Queue System

🔐 Authentication System

The API uses token-based authentication implemented with Laravel Sanctum.

This approach allows:

secure API access

token-based session management

scalable client integration (mobile apps, web apps, etc.)

⚙️ Core Features
🔎 Charging Station Search

Users can search for charging stations using geographic filters such as:

city

specific location within the city

Each station contains metadata including:

connector type

power capacity (kW)

availability status

⚡ Reservation Management

Users can manage reservations for charging stations.

Supported actions include:

creating reservations

modifying reservation time slots

cancelling reservations

The system prevents overlapping reservations to ensure station availability integrity.

🤖 Automated Reservation Lifecycle

The platform automates reservation state transitions using Laravel queues and jobs.

Reservation lifecycle:

| Job                    | Responsibility                                           |
| ---------------------- | -------------------------------------------------------- |
| StartChargingJob       | Marks reservation as charging when start time is reached |
| CompleteReservationJob | Marks reservation as completed when end time is reached  |
