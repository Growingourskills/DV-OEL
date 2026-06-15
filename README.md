<div align="center">

# 📊 E-commerce Customer Behavior Analytics

**Data Visualization Lab — Open Ended Lab Project**

*IQRA University, Chak Shahzad Campus, Islamabad*

![Python](https://img.shields.io/badge/Python-3.12-3776AB?style=for-the-badge&logo=python&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Jupyter](https://img.shields.io/badge/Jupyter-Notebook-F37626?style=for-the-badge&logo=jupyter&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-4.4-FF6384?style=for-the-badge&logo=chart.js&logoColor=white)

---

**Course:** AIN-375L Data Visualization Lab &nbsp;|&nbsp; **Semester:** BSAI-6 &nbsp;|&nbsp; **Instructor:** Abdul Baqi Malik

</div>

---

## 📁 Project Structure

```
DV-Lab-OEL/
│
├── course-work/                    ← Main graded work (Jupyter Notebook)
│   ├── dataset/
│   │   └── ecommerce_data.csv      ← 1634 records, 20 columns
│   ├── DV_OEL_Project.ipynb        ← Complete analysis notebook
│   ├── generate_dataset.js         ← Dataset generator script
│   └── visualizations/             ← Charts saved here after running
│
├── dashboard/                      ← Extra marks: Laravel web dashboard
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   └── DashboardController.php
│   │   └── Models/
│   │       └── Order.php
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── public/css/
│   │   └── style.css               ← NeoBrutalism design
│   ├── resources/views/
│   │   ├── layouts/app.blade.php
│   │   └── dashboard/              ← 4 pages
│   ├── routes/web.php
│   ├── .env.example
│   └── composer.json
│
├── report/                         ← PDF report goes here
└── README.md
```

---

## 🗃️ Dataset

**File:** `course-work/dataset/ecommerce_data.csv`

| Detail | Value |
|--------|-------|
| Total Records | **1,634** |
| Total Columns | **20** |
| Date Range | Jan 2024 – May 2025 |
| Market | Pakistan (10 major cities) |

### Columns

| Column | Description |
|--------|-------------|
| `customer_id` | Unique customer code (C001–C300) |
| `customer_name` | Pakistani customer name |
| `age` | Customer age (18–65) |
| `gender` | Male / Female |
| `city` | One of 10 Pakistani cities |
| `registration_date` | When customer joined |
| `order_id` | Unique order code |
| `order_date` | Order date |
| `product_category` | Electronics, Clothing, Books, etc. |
| `product_name` | Specific product |
| `unit_price` | Price per item (PKR) |
| `quantity` | Number of items |
| `total_amount` | Final amount paid (PKR) |
| `payment_method` | Credit Card, JazzCash, EasyPaisa, etc. |
| `discount_applied` | Yes / No |
| `discount_percent` | 0, 5, 10, 15, or 20 |
| `satisfaction_score` | Rating 1–5 |
| `session_duration_min` | Time spent (minutes) |
| `device_type` | Mobile / Desktop / Tablet |
| `num_previous_purchases` | Customer's order history count |

---

## 📓 Part 1: Jupyter Notebook

### What It Covers

| Requirement | Status |
|-------------|--------|
| Data Preprocessing (missing values, outliers, feature engineering) | ✅ |
| EDA with Pandas and NumPy | ✅ |
| 15+ Visualizations | ✅ **17 charts** |
| K-Means Customer Segmentation | ✅ |
| Time Series Analysis | ✅ |
| Statistical Analysis (distributions) | ✅ |
| Interactive / Dashboard visualizations (Plotly) | ✅ |
| Decision-making insights for every chart | ✅ |

### Visualization List

| # | Type | Title |
|---|------|-------|
| 1 | Bar Chart | Total Sales by Product Category |
| 2 | Horizontal Bar | Revenue by City |
| 3 | Line Chart | Monthly Sales Trend |
| 4 | Line Chart | Weekly Order Count with Moving Average |
| 5 | Heatmap | Correlation Matrix |
| 6 | Scatter Plot | Customer Age vs Total Spending |
| 7 | Scatter Plot | Session Duration vs Amount |
| 8 | Pie Chart | Payment Method Distribution |
| 9 | Pie Chart | Gender Distribution |
| 10 | Box Plot | Unit Price by Category |
| 11 | Box Plot | Satisfaction Score by Payment Method |
| 12 | Distribution | Age Histogram + KDE |
| 13 | Distribution | Order Amount Histogram |
| 14 | Violin Plot | Spending by Gender |
| 15 | Count Plot | Orders by Day of Week |
| 16 | Stacked Bar | Category Sales by Gender |
| 17 | Bar Chart | Orders by Device Type |
| + | Elbow Plot | K-Means Best K Selection |
| + | Scatter Plot | Customer Segments (3 Clusters) |
| + | Line Chart | Daily Sales with Rolling Averages |
| + | Pair Plot | Multi-feature Relationships |
| + | Interactive | Plotly Scatter + Bar + 4-panel Dashboard |

### How to Run the Notebook

**Step 1 — Install Python**

Download from [python.org](https://www.python.org/downloads/). During installation, **check the box "Add Python to PATH"**.

**Step 2 — Install required libraries**

Open Command Prompt and run:
```bash
pip install pandas numpy matplotlib seaborn plotly scikit-learn scipy
```

**Step 3 — Open the notebook**

Open VS Code, navigate to `course-work/` and open `DV_OEL_Project.ipynb`.

**Step 4 — Update your info**

In the first cell of the notebook, update:
- `[Your Name]` → your real name
- `[Your Roll Number]` → your actual roll number

**Step 5 — Run all cells**

Press `Ctrl+Shift+P` → type `Run All Cells` → Enter.

All charts will show on screen. PNG files will be saved in `course-work/visualizations/`.

---

## 🖥️ Part 2: Laravel Dashboard

A NeoBrutalism-styled web dashboard built with PHP Laravel, MySQL, HTML, CSS, JavaScript, Chart.js, and Lucide Icons.

### Pages

| Page | URL | Description |
|------|-----|-------------|
| Dashboard Home | `/` | 4 stat cards + 4 live charts |
| Customer Analysis | `/customers` | Demographics + top customers |
| Sales Analytics | `/sales` | Revenue trends + category breakdown |
| Data Explorer | `/explorer` | Filter and browse all orders |

### Design System

NeoBrutalism style:
- **3px solid black borders** on all cards
- **5px hard shadow** (no blur) — moves to 8px on hover
- **Bold color palette:** Yellow `#FFD700`, Pink `#FF6B9D`, Teal `#4ECDC4`, Purple `#A855F7`
- **Space Grotesk** font from Google Fonts
- **Slide-up animations** on page load
- **Mobile responsive** — sidebar collapses on small screens

### How to Run the Dashboard

**Prerequisite — Install Laragon**

Download from [laragon.org](https://laragon.org/download/). Install and start it. Laragon gives you PHP, MySQL, and Composer all in one.

**Step 1 — Create the database**

Open Laragon → HeidiSQL (or any MySQL client) and run:
```sql
CREATE DATABASE dv_analytics;
```

**Step 2 — Configure environment**

Copy `.env.example` to `.env` inside the `dashboard/` folder:
```bash
copy .env.example .env
```

Edit `.env` and set:
```
DB_DATABASE=dv_analytics
DB_USERNAME=root
DB_PASSWORD=
```

**Step 3 — Install Laravel**

Open Laragon terminal, go to the dashboard folder:
```bash
cd "c:\Users\SL LAPTOP\OneDrive\Desktop\Nouman Data\DV-Lab-OEL\dashboard"
composer install
php artisan key:generate
```

**Step 4 — Setup database**

```bash
php artisan migrate
php artisan db:seed
```

This imports all 1634 records from the CSV into MySQL automatically.

**Step 5 — Start the server**

```bash
php artisan serve
```

Open your browser and go to: **http://localhost:8000**

---

## 🛠️ Tech Stack

| Tool | Purpose |
|------|---------|
| Python 3.12 | Data analysis and visualization |
| Pandas | Data manipulation |
| NumPy | Numerical operations |
| Matplotlib | Static charts |
| Seaborn | Statistical charts |
| Plotly | Interactive charts |
| Scikit-learn | K-Means clustering, StandardScaler |
| SciPy | Statistical tests |
| PHP Laravel 11 | Web framework for dashboard |
| MySQL | Database for dashboard |
| HTML + CSS + JS | Frontend |
| Chart.js | Browser charts in dashboard |
| Lucide Icons | Dashboard icons |
| Node.js | Dataset generator script |

---

## 📂 Submission Deliverables

- [x] Jupyter Notebook (`.ipynb`)
- [x] Dataset (`ecommerce_data.csv`)
- [ ] Project Report PDF → place in `report/` folder
- [ ] Screenshots of dashboard → capture after running

---

## 📚 References

- Pandas Documentation: https://pandas.pydata.org/docs/
- Matplotlib Documentation: https://matplotlib.org/
- Seaborn Documentation: https://seaborn.pydata.org/
- Plotly Documentation: https://plotly.com/python/
- Scikit-learn Documentation: https://scikit-learn.org/
- SciPy Documentation: https://docs.scipy.org/
- Chart.js Documentation: https://www.chartjs.org/
- Lucide Icons: https://lucide.dev/
- Laravel Documentation: https://laravel.com/docs/
- Book Reference: *Data Visualization in Python*, Daniel Nelson (September 2020)
- Dataset: Synthetic dataset generated using Pakistani e-commerce market patterns

---

<div align="center">
<strong>IQRA University · AIN-375L Data Visualization Lab · 2026</strong>
</div>
