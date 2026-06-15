# VIVA & Presentation Preparation Guide

**Course:** AIN-375L Data Visualization Lab
**Project:** E-commerce Customer Behavior Analysis

---

> Read this document before your presentation and viva. It explains every part of the project in simple words. If sir asks you to change something, check the "How to Change" sections.

---

## Part 1: What This Project Does (Simple Explanation)

We took a dataset of 1634 online shopping orders from Pakistani customers. We cleaned the data, made charts to understand it, grouped customers into segments, and built a web dashboard to show the results nicely.

**Main Goal:** Find useful patterns in customer buying behavior so a business can make better decisions.

---

## Part 2: The Dataset Explained

**File:** `course-work/dataset/ecommerce_data.csv`

We generated this dataset using a Node.js script (`generate_dataset.js`). It creates fake but realistic data based on Pakistan's e-commerce market.

### What Each Column Means

| Column Name | Simple Meaning | Example |
|-------------|---------------|---------|
| `customer_id` | A code for each customer | C001 |
| `customer_name` | Customer's full name | Ahmed Khan |
| `age` | How old the customer is | 29 |
| `gender` | Male or Female | Male |
| `city` | Which Pakistani city | Karachi |
| `registration_date` | When they made an account | 2023-07-06 |
| `order_id` | A code for each order | ORD0001 |
| `order_date` | When the order was placed | 2024-01-21 |
| `product_category` | Type of product | Electronics |
| `product_name` | Exact product | Wireless Earbuds |
| `unit_price` | Price of one item in PKR | 13553 |
| `quantity` | How many items ordered | 2 |
| `total_amount` | Final amount paid | 27106 |
| `payment_method` | How they paid | JazzCash |
| `discount_applied` | Was there a discount | Yes |
| `discount_percent` | How much discount | 10 |
| `satisfaction_score` | Rating out of 5 | 4 |
| `session_duration_min` | How long on website | 42 |
| `device_type` | What device used | Mobile |
| `num_previous_purchases` | Orders before this | 16 |

### If Sir Asks: "Why did you use synthetic data?"

Say: "We generated our own dataset to have full control over the data structure. This also avoids plagiarism since it is original data based on Pakistani market patterns. The dataset has 1634 records which is more than the required 1000."

### If Sir Says: "Change the number of records"

Open `course-work/generate_dataset.js`. Find this line:
```javascript
for (let i = 1; i <= 300; i++) {
```
Change `300` to more (e.g., `500` for ~2700 records). Then run:
```
node generate_dataset.js
```

---

## Part 3: The Jupyter Notebook Explained

**File:** `course-work/DV_OEL_Project.ipynb`

The notebook has 11 sections. Here is what each section does.

---

### Section 1: Import Libraries

```python
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
from sklearn.preprocessing import StandardScaler
from sklearn.cluster import KMeans
from scipy import stats
import plotly.express as px
```

**What this does:** Loads all the tools we need. Like loading your toolbox before starting work.

| Library | What It Does |
|---------|-------------|
| `pandas` | Reads CSV files, makes tables, filters data |
| `numpy` | Does math operations on numbers |
| `matplotlib` | Makes basic charts |
| `seaborn` | Makes prettier statistical charts |
| `sklearn` | Machine learning tools (K-Means clustering) |
| `scipy` | Statistical tests (chi-square, Shapiro-Wilk) |
| `plotly` | Makes interactive charts (can hover, zoom) |

---

### Section 2: Load Dataset

```python
df = pd.read_csv('dataset/ecommerce_data.csv')
print('Dataset shape:', df.shape)
df.head(10)
```

**What this does:** Reads the CSV file into a table called `df`. `.head(10)` shows the first 10 rows.

**`df.info()`** — shows column names, how many values are in each column, and what type of data each column has (text, number, etc.)

---

### Section 3: Data Preprocessing

This is cleaning the data. Four steps:

**Step 1 — Missing Values**
```python
df = df.ffill()
```
"Fill forward" — if a cell is empty, copy the value from the row above it.

**Step 2 — Duplicates**
```python
df = df.drop_duplicates()
```
Remove rows that appear more than once.

**Step 3 — Outlier Removal (IQR Method)**
```python
Q1 = df['total_amount'].quantile(0.25)
Q3 = df['total_amount'].quantile(0.75)
IQR = Q3 - Q1
lower = Q1 - 1.5 * IQR
upper = Q3 + 1.5 * IQR
```

**What is IQR?** IQR = Interquartile Range. It is the middle 50% of the data. Any value below `lower` or above `upper` is an outlier and we remove it.

If sir asks: "What is Q1 and Q3?" — Q1 is the 25th percentile (25% of data is below it). Q3 is the 75th percentile (75% of data is below it).

**Step 4 — Feature Engineering**
```python
df['order_month'] = df['order_date'].dt.month
df['day_of_week'] = df['order_date'].dt.day_name()
df['age_group'] = pd.cut(df['age'], bins=[17,25,35,45,55,66], labels=['18-25','26-35','36-45','46-55','56-65'])
df['spending_level'] = pd.cut(df['total_amount'], bins=[0,3000,8000,15000,60000], labels=['Low','Medium','High','Very High'])
```

Feature engineering means creating new columns from existing data. We extract month and day from dates. We group ages and spending into categories.

---

### Section 4: EDA (Exploratory Data Analysis)

EDA means exploring the data to understand it before making charts.

```python
df.describe()
```
Shows min, max, mean, median, and standard deviation for all number columns.

```python
df['gender'].value_counts()
```
Counts how many males and females there are.

```python
df.groupby('product_category')['total_amount'].sum()
```
Adds up total sales for each product category.

**Key EDA Findings to Mention in Presentation:**
- Electronics has the highest total sales
- Mobile is the most used device
- Cash on Delivery and JazzCash are the most popular payment methods
- Customer ages are spread evenly from 18 to 65

---

### Section 5: The 17 Visualizations

Every chart has 4 parts: **Title**, **X-axis label**, **Y-axis label**, **Interpretation**.

Here is what each chart shows and why it matters:

**Chart 1 — Bar Chart: Sales by Category**
Shows which product category makes the most money. Electronics is usually top. Tells the business where to focus.

**Chart 2 — Horizontal Bar: Revenue by City**
Shows which city brings in the most revenue. Karachi and Lahore are usually the biggest.

**Chart 3 — Line Chart: Monthly Sales**
Shows how sales go up and down each month. Helps find busy seasons.

**Chart 4 — Line Chart: Weekly Orders with Moving Average**
Same as monthly but weekly. The moving average (red line) smooths out the ups and downs to show the real trend.

**Chart 5 — Heatmap: Correlation Matrix**
Shows how strongly two numbers are related. A value near 1 means strong positive relation. Near -1 means opposite relation. Near 0 means no relation.

**Chart 6 — Scatter Plot: Age vs Spending**
Each dot is one customer. X = age, Y = how much they spent. We look for patterns.

**Chart 7 — Scatter Plot: Session Duration vs Amount**
Does staying longer on the site mean buying more? This chart answers that.

**Chart 8 — Pie Chart: Payment Methods**
Shows the percentage share of each payment method.

**Chart 9 — Pie Chart: Gender**
Shows male vs female customer split.

**Chart 10 — Box Plot: Price by Category**
A box plot shows the range of prices. The box = middle 50% of data. The lines = full range. Dots outside = outliers.

**Chart 11 — Box Plot: Satisfaction by Payment**
Does payment method affect how happy customers are?

**Chart 12 — Distribution: Age**
Histogram with KDE (smooth curve on top). KDE = Kernel Density Estimation — it estimates the probability of each age.

**Chart 13 — Distribution: Order Amount**
Similar to age but for money. We add mean and median lines to compare.

**Chart 14 — Violin Plot: Spending by Gender**
A violin plot is like a box plot but shows the shape of data too. Wide areas mean more data there.

**Chart 15 — Count Plot: Orders by Day**
How many orders come on each day of the week? Useful for planning.

**Chart 16 — Stacked Bar: Category by Gender**
Shows which gender buys from which category.

**Chart 17 — Bar Chart: Device Type**
Mobile vs Desktop vs Tablet usage.

### If Sir Says "Change a Chart Color"

Find the chart in the notebook. Look for lines like:
```python
color='#4ECDC4'
```
Change the hex color code. Examples:
- `#FF0000` = Red
- `#0000FF` = Blue
- `#00FF00` = Green

---

### Section 6: K-Means Clustering

**What is K-Means?** It is a machine learning algorithm that groups similar items together automatically.

**Steps we follow:**

1. Select features: `total_spending`, `num_orders`, `avg_session`
2. Normalize data using `StandardScaler` (make all values between 0 and 1)
3. Try K = 2, 3, 4, 5, 6, 7, 8 and measure inertia (how tight the clusters are)
4. Plot the "elbow" — where inertia stops dropping fast = best K
5. We choose K=3 and run K-Means
6. Plot the 3 clusters in different colors

**The 3 Clusters:**
- **Cluster 0:** Regular buyers — medium spending, average orders
- **Cluster 1:** Low-value — low spending, fewer orders (new or inactive customers)
- **Cluster 2:** High-value — most spending, most orders (VIP customers)

**Why StandardScaler?** Because `total_spending` can be in tens of thousands while `num_orders` is 3–8. Without scaling, the algorithm would only care about the big numbers.

**If Sir Asks: "What is inertia?"**
Inertia is the total distance of all points from their cluster center. Lower inertia = tighter, better clusters. But we don't want too many clusters — find the balance at the "elbow" of the curve.

---

### Section 7: Time Series Analysis

Time series means looking at data over time.

**Daily with Rolling Average:**
```python
daily = df.set_index('order_date').resample('D')['total_amount'].sum()
rolling7 = daily.rolling(window=7).mean()
```
`resample('D')` groups data by day. `rolling(7)` takes the average of the last 7 days at each point.

We plot:
- Raw daily sales (noisy — goes up and down a lot)
- 7-day rolling average (smoother trend)
- 30-day rolling average (even smoother — shows the big picture)

**Monthly Revenue:** `resample('M')` groups by month.

**Day of Week:** Groups by Monday, Tuesday, etc. to find patterns.

---

### Section 8: Statistical Analysis

**Normal Distribution Fit:**
We draw the actual data as a histogram and overlay a normal bell curve. Most real sales data is right-skewed (not perfectly normal) — the curve doesn't perfectly match.

**Z-Score:**
```python
df['z_score'] = np.abs(stats.zscore(df['total_amount']))
outliers = (df['z_score'] > 3).sum()
```
Z-score tells how far a value is from the mean. More than 3 means it's an extreme outlier.

**Shapiro-Wilk Test:**
Tests if the data follows a normal distribution. If p-value < 0.05, data is NOT normal.

**Chi-Square Test:**
Tests if two categories are related. We test: Does gender affect discount usage?

If p-value < 0.05 → Yes, there is a significant relationship.
If p-value >= 0.05 → No significant relationship.

---

### Section 9: Interactive Plotly Charts

Plotly charts are interactive — you can hover on data points and see their values.

```python
fig = px.scatter(df, x='age', y='total_amount', color='product_category', ...)
fig.show()
```

We also create a 4-panel dashboard combining:
- Monthly revenue line
- Top 5 categories bar
- Payment methods pie
- Avg spending by age group

---

## Part 4: The Dashboard Explained

**Location:** `dashboard/` folder

**Tech used:** PHP Laravel, MySQL, HTML, CSS (NeoBrutalism), Vanilla JavaScript, Chart.js, Lucide Icons

---

### File-by-File Explanation

**`routes/web.php`**

This file defines the URLs of the website.

```php
Route::get('/', [DashboardController::class, 'index']);
Route::get('/customers', [DashboardController::class, 'customers']);
Route::get('/sales', [DashboardController::class, 'sales']);
Route::get('/explorer', [DashboardController::class, 'explorer']);
```

When someone opens `/`, Laravel calls the `index` method. When they open `/customers`, it calls `customers`, and so on.

---

**`app/Http/Controllers/DashboardController.php`**

The brain of the dashboard. It gets data from the database and sends it to the views.

- `index()` — Gets total sales, orders, customers, average order → sends to home page
- `customers()` — Gets gender split, age groups, top 10 customers
- `sales()` — Gets sales by category and city
- `explorer()` — Gets filtered, paginated list of orders
- `chartData()` — Returns JSON for charts on home page
- `salesData()` — Returns JSON for charts on sales page
- `customerData()` — Returns JSON for customer charts

Why JSON? Because Chart.js (in JavaScript) needs JSON data to draw charts.

---

**`app/Models/Order.php`**

Tells Laravel what the `orders` database table looks like.

```php
protected $table = 'orders';
protected $fillable = ['customer_id', 'customer_name', ...];
```

`$fillable` = list of columns that can be filled with data.

---

**`database/migrations/2024_01_01_..._create_orders_table.php`**

This creates the `orders` table in MySQL when you run `php artisan migrate`.

```php
$table->string('customer_id', 10);
$table->integer('unit_price');
$table->date('order_date');
$table->index('customer_id');
```

We add `index()` on commonly searched columns to make queries faster.

---

**`database/seeders/DataSeeder.php`**

This reads the CSV file and puts all 1634 rows into the MySQL database.

```php
$file = fopen($csvPath, 'r');
$header = fgetcsv($file); // skip header row
while (($row = fgetcsv($file)) !== false) {
    $batch[] = [...]; // build row data
    if (count($batch) >= 100) {
        DB::table('orders')->insert($batch); // bulk insert 100 at a time
        $batch = [];
    }
}
```

Inserting 100 rows at a time (batching) is faster than inserting one by one.

---

**`public/css/style.css`**

The NeoBrutalism design system. Key properties:

```css
--border: 3px solid #1a1a2e;
--shadow: 5px 5px 0px #1a1a2e;
--shadow-hover: 8px 8px 0px #1a1a2e;
```

- **Thick borders** — makes elements look bold and clear
- **Hard shadows** (no blur) — the key feature of NeoBrutalism
- **Hover effect** — shadow gets bigger and card moves slightly when you hover

---

**`resources/views/layouts/app.blade.php`**

The main template that all pages share. It has:
- The `<head>` with CSS and CDN links
- The sidebar with navigation links
- `@yield('content')` — a placeholder where each page puts its own content
- `@yield('scripts')` — for page-specific JavaScript

---

**Dashboard Pages:**

| Page | File | What It Shows |
|------|------|--------------|
| Home | `dashboard/index.blade.php` | 4 stat cards + 4 Chart.js charts |
| Customers | `dashboard/customers.blade.php` | Gender, age, spending, top 10 |
| Sales | `dashboard/sales.blade.php` | Revenue trends, city, day analysis |
| Explorer | `dashboard/explorer.blade.php` | Filterable table with pagination |

---

## Part 5: Viva Questions and Answers

**Q: What is data visualization?**
A: Data visualization is showing data in charts and graphs so it is easier to understand patterns, trends, and insights that are hard to see in raw numbers.

**Q: Why did you choose Python for this project?**
A: Python has powerful libraries like Pandas, Matplotlib, Seaborn, and Plotly that make data analysis easy. It is also the standard language for data science.

**Q: What is EDA?**
A: EDA stands for Exploratory Data Analysis. It is the first step where we explore the data to understand its structure, find patterns, check for missing values, and understand distributions before doing advanced analysis.

**Q: What is K-Means clustering?**
A: K-Means groups data points into K clusters so that similar points are in the same group. It assigns each point to the nearest cluster center, then moves the center to the average of the group. It repeats this until clusters don't change.

**Q: Why did you use StandardScaler before K-Means?**
A: Different features have different scales. Spending is in thousands while number of orders is in single digits. Without scaling, spending would dominate the clustering. StandardScaler makes all features have mean=0 and std=1.

**Q: What is the elbow method?**
A: We try different values of K (2, 3, 4, ...) and measure inertia for each. Inertia goes down as K increases. We pick K where inertia stops dropping fast — this looks like an elbow in the graph.

**Q: What is the IQR method for outlier detection?**
A: IQR = Q3 - Q1 (the middle 50% range). Values below Q1 - 1.5×IQR or above Q3 + 1.5×IQR are outliers. We remove them to prevent them from affecting our analysis.

**Q: What is a time series?**
A: Time series data is data collected over time at regular intervals. We analyze it to find trends (long-term direction), seasonality (repeating patterns), and anomalies.

**Q: What is the difference between Matplotlib and Seaborn?**
A: Matplotlib is the base library — very flexible but requires more code. Seaborn is built on top of Matplotlib — it makes statistical charts (like box plots, violin plots, heatmaps) with less code and nicer default styling.

**Q: What is Plotly?**
A: Plotly makes interactive charts. Users can hover over data points to see exact values, zoom in, and pan. This is better for dashboards and presentations than static images.

**Q: What is a heatmap?**
A: A heatmap uses colors to represent values in a matrix. In a correlation heatmap, darker red = strong positive correlation, darker blue = strong negative correlation, white = no correlation.

**Q: What is a box plot?**
A: A box plot shows: the median (middle line), Q1 and Q3 (the box edges), the range of non-outlier data (the whiskers), and outliers (dots outside).

**Q: What is a violin plot?**
A: A violin plot is like a box plot but also shows the distribution shape — where the "violin" is wider means more data exists at that value.

**Q: What is a correlation?**
A: Correlation measures how two variables are related. Correlation = 1 means they move together. Correlation = -1 means they move opposite. Correlation = 0 means no relationship.

**Q: What is feature engineering?**
A: Feature engineering is creating new columns from existing data to make analysis easier. For example, we extracted `order_month` and `day_of_week` from the `order_date` column.

**Q: What is the chi-square test?**
A: Chi-square test checks if two categorical variables are related. For example, we tested if gender affects discount usage. If p-value < 0.05, there is a significant relationship.

**Q: What is the Shapiro-Wilk test?**
A: It tests if data follows a normal (bell curve) distribution. If p-value < 0.05, the data is NOT normally distributed.

**Q: What is NeoBrutalism in web design?**
A: NeoBrutalism is a modern web design style that uses thick black borders, hard shadows (no blur), bold flat colors, and strong typography. It makes interfaces look bold and functional.

**Q: What is Laravel?**
A: Laravel is a PHP web framework. It makes it easier to build websites by providing ready-made tools for routing, database operations, templating, and more.

**Q: What is a database migration in Laravel?**
A: A migration is a PHP file that describes the structure of a database table. When you run `php artisan migrate`, Laravel creates the table in the database automatically.

**Q: What is a seeder?**
A: A seeder is a script that fills the database with data. We used a seeder to import all 1634 rows from the CSV file into MySQL.

**Q: What is MVC architecture?**
A: MVC stands for Model-View-Controller. Model = database interaction. View = what the user sees (HTML). Controller = connects Model and View, contains the logic. Laravel uses MVC.

**Q: What does `php artisan` do?**
A: `artisan` is Laravel's command-line tool. Common commands: `migrate` (creates tables), `db:seed` (fills data), `serve` (starts the web server), `key:generate` (creates app encryption key).

---

## Part 6: How to Change Things If Sir Asks

### Change the Number of Records
File: `course-work/generate_dataset.js`
```javascript
for (let i = 1; i <= 300; i++) {  // Change 300 to more
```
Then run: `node generate_dataset.js`

### Add a New Chart
In the notebook, create a new cell:
```python
plt.figure(figsize=(10, 6))
# your chart code
plt.title('Your Title', fontsize=14, fontweight='bold')
plt.xlabel('X Label')
plt.ylabel('Y Label')
plt.tight_layout()
plt.savefig('visualizations/new_chart.png', dpi=150)
plt.show()
```
Then add a new markdown cell below with the interpretation.

### Change Chart Colors
Find the color parameter in any chart:
```python
color='#4ECDC4'     # change to any hex color
palette='viridis'   # change to 'Set1', 'Set2', 'coolwarm', 'Blues', etc.
```

### Change Number of Clusters
In Section 6 of the notebook:
```python
km = KMeans(n_clusters=3, ...)  # change 3 to 4 or 5
```
Also update the elbow chart interpretation.

### Add a New Dashboard Page
1. Add route in `dashboard/routes/web.php`
2. Add method in `DashboardController.php`
3. Create view file in `dashboard/resources/views/dashboard/`
4. Add sidebar link in `dashboard/resources/views/layouts/app.blade.php`

### Change Dashboard Colors
In `dashboard/public/css/style.css`, edit CSS variables:
```css
:root {
    --yellow: #FFD700;   /* change any of these */
    --pink: #FF6B9D;
    --teal: #4ECDC4;
    --purple: #A855F7;
}
```

---

## Part 7: Key Insights to Mention in Presentation

1. **Electronics and Home & Kitchen** generate the most revenue → Stock these more
2. **Karachi and Lahore** are top revenue cities → Focus marketing there
3. **Mobile devices** are used most → Website must be mobile-friendly
4. **Cash on Delivery and JazzCash** are most popular → Keep these payment options
5. **Three customer segments found:** VIP (high spend), Regular (medium), Inactive (low spend)
6. **Customers with discounts** tend to have higher satisfaction scores
7. **Age has no strong effect** on spending → Target all age groups equally
8. **Sales data is right-skewed** → Most orders are small; bundle deals could increase average order

---

## Part 8: Quick Reference — Libraries Used

```python
import pandas as pd          # pd.read_csv(), df.head(), df.describe(), df.groupby()
import numpy as np           # np.abs(), np.linspace(), np.ones_like()
import matplotlib.pyplot as plt   # plt.figure(), plt.plot(), plt.bar(), plt.show()
import seaborn as sns        # sns.heatmap(), sns.boxplot(), sns.histplot(), sns.violinplot()
from sklearn.preprocessing import StandardScaler   # scale features to same range
from sklearn.cluster import KMeans                 # KMeans(n_clusters=3).fit()
from scipy import stats      # stats.norm.pdf(), stats.zscore(), stats.shapiro(), stats.chi2_contingency()
import plotly.express as px  # px.scatter(), px.bar()
import plotly.graph_objects as go   # go.Scatter(), go.Bar(), go.Pie()
from plotly.subplots import make_subplots   # multi-panel dashboard
```

---

*Good luck in your presentation and viva!*
