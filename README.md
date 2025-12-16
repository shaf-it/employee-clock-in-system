# Employee Clock-In System
Card-based employee attendance tracking system using Raspberry Pi


## Overview
The Employee Clock-In System is a digital attendance tracking solution designed to replace manual, paper-based clock-in logs. It allows employees to clock in, clock out, and record lunch or off-site breaks using a card swipe system. All attendance data is stored digitally and can be viewed by an administrator for easy tracking and review.

## Problem Statement
Manual attendance tracking is time-consuming, error-prone, and difficult to manage. This system automates the process by recording employee attendance accurately and displaying confirmation instantly after each action.

## Features
- Card-based clock-in and clock-out
- Lunch and off-site break tracking
- Automatic date and time recording
- Employee confirmation display
- Admin view with full employee attendance records
- Secure and centralized data storage

## How It Works
1. An employee swipes their card on arrival, during lunch/off-site breaks, or on departure.
2. The system records the employee ID, time, and date.
3. The employee sees a confirmation message showing that they have successfully clocked in or out.
4. Administrators can view all attendance records for monitoring and reporting purposes.

## Technologies Used
- **Frontend:** JavaScript
- **Backend:** PHP (XAMPP)
- **Database:** MySQL (phpMyAdmin)
- **Hardware:** Raspberry Pi with card reader
- **Environment:** Local server hosted on Raspberry Pi

## My Role
This project was completed as a final project in collaboration with a teammate.  
I was responsible for the **entire software development**, including:
- Processing card swipe data received by the Raspberry Pi
- Storing attendance records in the database
- Displaying real-time confirmation on the screen
- Ensuring accurate communication between hardware input and the software system

The hardware components were handled by my teammate.

## Project Status
✅ Fully working

## Future Improvements
- Admin dashboard with reports and filters
- Web-based remote access for administrators
- Support for multiple business locations
- Enhanced security and authentication
