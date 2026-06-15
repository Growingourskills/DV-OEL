# DV Lab OEL - Project Walkthrough

## What Was Built

### Project Structure
```
DV-Lab-OEL/
├── README.md
├── course-work/
│   ├── dataset/
│   │   └── ecommerce_data.csv          (1634 records, 20 columns)
│   ├── generate_dataset.js              (Node.js data generator)
│   ├── DV_OEL_Project.ipynb            (Main Jupyter Notebook)
│   └── visualizations/                  (Charts saved here when notebook runs)
├── dashboard/
│   ├── .env.example
│   ├── composer.json
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   └── DashboardController.php  (7 methods: 4 pages + 3 APIs)
│   │   └── Models/
│   │       └── Order.php
│   ├── database/
│   │   ├── migrations/
│   │   │   └── 2024_01_01_..._create_orders_table.php
│   │   └── seeders/
│   │       ├── DatabaseSeeder.php
│   │       └── DataSeeder.php           (CSV to MySQL importer)
│   ├── public/css/
│   │   └── style.css                    (NeoBrutalism design system)
│   ├── resources/views/
│   │   ├── layouts/app.blade.php        (Sidebar + Lucide icons)
│   │   └── dashboard/
│   │       ├── index.blade.php          (Home: 4 stat cards + 4 charts)
│   │       ├── customers.blade.php      (Age groups + spending + top 10)
│   │       ├── sales.blade.php          (Trends + city + day analysis)
│   │       └── explorer.blade.php       (Filtered table + pagination)
│   └── routes/web.php
└── report/                              (For PDF report)
```

---

## Part 1: Jupyter Notebook (Course Work)

[DV_OEL_Project.ipynb](file:///c:/Users/SL LAPTOP/OneDrive/Desktop/Nouman Data/DV-Lab-OEL/course-work/DV_OEL_Project.ipynb)

### Dataset
- [ecommerce_data.csv](file:///c:/Users/SL LAPTOP/OneDrive/Desktop/Nouman Data/DV-Lab-OEL/course-work/dataset/ecommerce_data.csv) — 1634 records
- 20 columns: customer info, order details, payment, satisfaction, session, device
- Pakistani cities, product categories, payment methods (JazzCash, EasyPaisa, COD)

### Notebook Sections (11 sections, ~50 cells)

| Section | What It Covers |
|---------|---------------|
| 1. Import Libraries | pandas, numpy, matplotlib, seaborn, plotly, sklearn, scipy |
| 2. Load Dataset | Read CSV, check shape, info |
| 3. Data Preprocessing | Missing values, duplicates, IQR outliers, feature engineering |
| 4. EDA | Descriptive stats, value counts, group-by, correlation |
| 5. Visualizations (17) | Bar, hbar, line, heatmap, scatter, pie, box, dist, violin, count, stacked, device |
| 6. K-Means Clustering | Elbow method + 3 customer segments |
| 7. Time Series | Daily rolling avg, monthly trend, day-of-week pattern |
| 8. Statistical Analysis | Normal fit, z-score, Shapiro-Wilk, chi-square test |
| 9. Interactive Plotly | Scatter, bar, 4-panel dashboard subplot |
| 10. Pair Plot | Multi-feature relationships |
| 11. Insights | 8 findings + 5 recommendations |

### Sir's Requirements Checklist
- [x] Data preprocessing (missing, outliers, feature engineering)
- [x] EDA with Pandas, NumPy
- [x] 17 visualizations (> 15 required)
- [x] Bar, Line, Heatmap, Scatter, Pie, Box, Distribution plots
- [x] K-Means clustering with visualization
- [x] Time series analysis (daily, weekly, monthly)
- [x] Statistical analysis (distributions, tests)
- [x] Interactive Plotly charts
- [x] Titles, labels, legends on every chart
- [x] Interpretation for every visualization

---

## Part 2: Dashboard (Laravel + NeoBrutalism)

### Design
- **NeoBrutalism style:** Thick 3px black borders, hard 5px shadows, bold colors
- **Color palette:** Yellow (#FFD700), Pink (#FF6B9D), Teal (#4ECDC4), Purple (#A855F7)
- **Font:** Space Grotesk (Google Fonts)
- **Icons:** Lucide Icons via CDN
- **Charts:** Chart.js
- **Animations:** Slide-up on page load, hover transforms on cards
- **Responsive:** Mobile sidebar collapses to icons only

### Pages
1. **Dashboard Home** — 4 stat cards + monthly trend + category bar + payment doughnut + device pie
2. **Customer Analysis** — Gender stats + age group bar + spending doughnut + top 10 table
3. **Sales Analytics** — Top 3 category cards + dual-axis trend + city hbar + day-of-week bar + full category table
4. **Data Explorer** — Filterable by category/city/gender + paginated table + star ratings

### Backend
- **DashboardController** — 4 page methods + 4 API endpoints returning JSON for charts
- **Order Model** — Maps to CSV columns with date casting
- **Migration** — Creates `orders` table with indexes on customer_id, order_date, product_category, city
- **DataSeeder** — Reads CSV in batches of 100 and bulk-inserts into MySQL

---

## What's Pending

> [!IMPORTANT]
> ### You need to install software before running anything:
> 
> **For Jupyter Notebook:**
> 1. Install Python from [python.org](https://www.python.org/downloads/) (check "Add to PATH")
> 2. Open terminal and run:
> ```
> pip install pandas numpy matplotlib seaborn plotly scikit-learn scipy
> ```
> 3. Open `course-work/DV_OEL_Project.ipynb` in VS Code and run all cells
> 4. Update your name and roll number in the first cell
> 
> **For Dashboard:**
> 1. Install [Laragon](https://laragon.org/download/) (gives PHP + MySQL + Composer)
> 2. Start Laragon and open its terminal
> 3. Create database: `mysql -u root -e "CREATE DATABASE dv_analytics;"`
> 4. Go to dashboard folder:
> ```
> cd dashboard
> copy .env.example .env
> composer install
> php artisan key:generate
> php artisan migrate
> php artisan db:seed
> php artisan serve
> ```
> 5. Open `http://localhost:8000`
> 
> **Fix npm (needed if you plan to use npm later):**
> ```powershell
> Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
> ```

> [!NOTE]
> The dashboard `composer.json` is minimal. When you run `composer install` with Laravel installed via Laragon, it will pull all Laravel framework files automatically.

---

## Code Style Notes
- All code is written in simple, beginner-friendly style
- Minimal comments — only where needed
- Simple English in all markdown cells and interpretations
- Short sentences throughout
- No AI-generated signals or patterns
