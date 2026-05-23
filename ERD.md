# Entity Relationship Diagram (ERD)
## Mamaua Volunteer Management System

---

## Database Schema

```
┌─────────────────────────────────────────────────────────────────┐
│                           USERS                                  │
├─────────────────────────────────────────────────────────────────┤
│ id (PK)                    BIGINT                                │
│ name                       VARCHAR                               │
│ email (UK)                 VARCHAR                               │
│ email_verified_at          TIMESTAMP NULLABLE                    │
│ password                   VARCHAR                               │
│ remember_token             VARCHAR NULLABLE                      │
│ is_admin                   BOOLEAN                               │
│ created_at                 TIMESTAMP                             │
│ updated_at                 TIMESTAMP                             │
└─────────────────────────────────────────────────────────────────┘
                            │
        ┌───────────────────┼───────────────────┐
        │                   │                   │
        ▼                   ▼                   ▼
┌───────────────┐  ┌───────────────┐  ┌───────────────┐
│  VOLUNTEERS   │  │ ORGANIZATIONS │  │    EVENTS     │
│ (1:1)         │  │ (1:N)         │  │ (1:N)         │
├───────────────┤  ├───────────────┤  ├───────────────┤
│ id (PK)       │  │ id (PK)       │  │ id (PK)       │
│ user_id (FK)  │  │ user_id (FK)  │  │ title         │
│ gender        │  │ org_name      │  │ description   │
│ marital_status│  │ category      │  │ event_date    │
│ created_at    │  │ type          │  │ start_time    │
│ updated_at    │  │ address       │  │ end_time      │
└───────────────┘  │ contact_num   │  │ location      │
                   │ email         │  │ req_volunteers│
                   │ description   │  │ status        │
                   │ status        │  │ approval_status│
                   │ created_at    │  │ created_by(FK)│
                   │ updated_at    │  │ org_id(FK)    │
                   └───────────────┘  │ image         │
                          │            │ created_at    │
                          │            │ updated_at    │
                          └────────────┘
                                       │
                                       │
                                       ▼
                              ┌────────────────┐
                              │ EVENT_USER     │
                              │ (Pivot - M:N)  │
                              ├────────────────┤
                              │ id (PK)        │
                              │ event_id (FK)  │
                              │ user_id (FK)   │
                              │ created_at     │
                              │ updated_at     │
                              └────────────────┘
                                       │
                                       │
                                       ▼
                              ┌────────────────┐
                              │ ANNOUNCEMENTS │
                              │ (1:N)         │
                              ├────────────────┤
                              │ id (PK)        │
                              │ event_id (FK)  │
                              │ user_id (FK)   │
                              │ message        │
                              │ created_at     │
                              │ updated_at     │
                              └────────────────┘
```

---

## Relationship Legend

| Symbol | Meaning |
|--------|---------|
| (PK)   | Primary Key |
| (FK)   | Foreign Key |
| (UK)   | Unique Key |
| 1:1    | One-to-One |
| 1:N    | One-to-Many |
| M:N    | Many-to-Many |

---

## Relationships Summary

### 1. User ↔ Volunteer (One-to-One)
- A user can have one volunteer profile
- A volunteer belongs to one user
- **Foreign Key**: volunteers.user_id → users.id
- **Cascade**: Delete user → delete volunteer

### 2. User ↔ Organizations (One-to-Many)
- A user can create multiple organizations
- An organization belongs to one user
- **Foreign Key**: organizations.user_id → users.id
- **Cascade**: Delete user → delete organizations

### 3. User ↔ Events (One-to-Many - as Creator)
- A user can create multiple events
- An event is created by one user
- **Foreign Key**: events.created_by → users.id
- **Cascade**: Delete user → delete events

### 4. Organization ↔ Events (One-to-Many)
- An organization can have multiple events
- An event belongs to one organization (optional)
- **Foreign Key**: events.organization_id → organizations.id
- **Cascade**: Delete organization → set events.organization_id to NULL

### 5. User ↔ Event (Many-to-Many - via event_user)
- A user can join multiple events
- An event can have multiple volunteers
- **Pivot Table**: event_user
- **Foreign Keys**: 
  - event_user.event_id → events.id
  - event_user.user_id → users.id
- **Unique Constraint**: (event_id, user_id) - prevents duplicate joins
- **Cascade**: Delete event/user → delete pivot records

### 6. Event ↔ Announcements (One-to-Many)
- An event can have multiple announcements
- An announcement belongs to one event
- **Foreign Key**: announcements.event_id → events.id
- **Cascade**: Delete event → delete announcements

### 7. User ↔ Announcements (One-to-Many)
- A user can post multiple announcements
- An announcement is posted by one user
- **Foreign Key**: announcements.user_id → users.id
- **Cascade**: Delete user → delete announcements

---

## Table Details

### USERS
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | User ID |
| name | VARCHAR | NOT NULL | Full name |
| email | VARCHAR | UNIQUE, NOT NULL | Email address |
| email_verified_at | TIMESTAMP | NULLABLE | Email verification time |
| password | VARCHAR | NOT NULL | Hashed password |
| remember_token | VARCHAR | NULLABLE | Remember me token |
| is_admin | BOOLEAN | DEFAULT: false | Admin flag |
| created_at | TIMESTAMP | | Created time |
| updated_at | TIMESTAMP | | Updated time |

### VOLUNTEERS
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Volunteer ID |
| user_id | BIGINT | FOREIGN KEY (users), ON DELETE CASCADE | User ID |
| gender | VARCHAR | NOT NULL | Gender |
| marital_status | VARCHAR | NOT NULL | Marital status |
| created_at | TIMESTAMP | | Created time |
| updated_at | TIMESTAMP | | Updated time |

### ORGANIZATIONS
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Organization ID |
| user_id | BIGINT | FOREIGN KEY (users), ON DELETE CASCADE | Owner ID |
| organization_name | VARCHAR | NOT NULL | Organization name |
| category | VARCHAR | NOT NULL | Category |
| type | VARCHAR | NOT NULL | Type |
| address | VARCHAR | NOT NULL | Address |
| contact_number | VARCHAR | NOT NULL | Contact number |
| email | VARCHAR | NOT NULL | Email |
| description | TEXT | NULLABLE | Description |
| status | VARCHAR | NOT NULL | Status (pending/approved/rejected) |
| created_at | TIMESTAMP | | Created time |
| updated_at | TIMESTAMP | | Updated time |

### EVENTS
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Event ID |
| title | VARCHAR | NOT NULL | Event title |
| description | TEXT | NOT NULL | Description |
| event_date | DATE | NOT NULL | Event date |
| start_time | TIME | NOT NULL | Start time |
| end_time | TIME | NOT NULL | End time |
| location | VARCHAR | NOT NULL | Location |
| required_volunteers | INT | DEFAULT: 0 | Volunteers needed |
| status | VARCHAR | DEFAULT: upcoming | Status (upcoming/ongoing/completed/cancelled) |
| approval_status | VARCHAR | NOT NULL | Approval (pending/approved/rejected) |
| created_by | BIGINT | FOREIGN KEY (users), ON DELETE CASCADE | Creator ID |
| organization_id | BIGINT | FOREIGN KEY (organizations), ON DELETE SET NULL, NULLABLE | Organization ID |
| image | VARCHAR | NULLABLE | Image path |
| created_at | TIMESTAMP | | Created time |
| updated_at | TIMESTAMP | | Updated time |

### EVENT_USER (Pivot Table)
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Record ID |
| event_id | BIGINT | FOREIGN KEY (events), ON DELETE CASCADE | Event ID |
| user_id | BIGINT | FOREIGN KEY (users), ON DELETE CASCADE | User ID |
| created_at | TIMESTAMP | | Created time |
| updated_at | TIMESTAMP | | Updated time |

**Unique Constraint**: (event_id, user_id)

### ANNOUNCEMENTS
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Announcement ID |
| event_id | BIGINT | FOREIGN KEY (events), ON DELETE CASCADE | Event ID |
| user_id | BIGINT | FOREIGN KEY (users), ON DELETE CASCADE | Poster ID |
| message | TEXT | NOT NULL | Message content |
| created_at | TIMESTAMP | | Created time |
| updated_at | TIMESTAMP | | Updated time |

---

## Business Rules

1. **User Roles**: Users can have roles (admin, organization, volunteer) via Spatie Permission package
2. **Organization Approval**: Organizations must be approved by admin before creating events
3. **Event Approval**: Events must be approved by admin before being visible to volunteers
4. **Event Status Flow**: upcoming → ongoing → completed (can be cancelled at any stage)
5. **Volunteer Joining**: A user can only join an event once (enforced by unique constraint)
6. **Event Ownership**: Events can be created by users with or without an organization
