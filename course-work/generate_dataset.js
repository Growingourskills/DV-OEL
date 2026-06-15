const fs = require('fs');
const path = require('path');

const datasetDir = path.join(__dirname, 'dataset');
if (!fs.existsSync(datasetDir)) {
    fs.mkdirSync(datasetDir, { recursive: true });
}

function randomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function pick(arr) {
    return arr[Math.floor(Math.random() * arr.length)];
}

function randomDate(startStr, endStr) {
    let start = new Date(startStr).getTime();
    let end = new Date(endStr).getTime();
    let d = new Date(start + Math.random() * (end - start));
    let y = d.getFullYear();
    let m = String(d.getMonth() + 1).padStart(2, '0');
    let day = String(d.getDate()).padStart(2, '0');
    return y + '-' + m + '-' + day;
}

const maleNames = [
    'Ahmed', 'Ali', 'Hassan', 'Usman', 'Bilal', 'Fahad', 'Omar', 'Hamza',
    'Zain', 'Saad', 'Kamran', 'Imran', 'Asad', 'Raza', 'Junaid', 'Waqar',
    'Tariq', 'Nadeem', 'Shahid', 'Faisal'
];

const femaleNames = [
    'Ayesha', 'Fatima', 'Hira', 'Sana', 'Noor', 'Amna', 'Zara', 'Maryam',
    'Iqra', 'Rabia', 'Sobia', 'Mehwish', 'Sumera', 'Tahira', 'Bushra',
    'Samina', 'Naila', 'Uzma', 'Parveen', 'Kiran'
];

const lastNames = [
    'Khan', 'Ahmed', 'Ali', 'Hussain', 'Malik', 'Shah', 'Butt', 'Iqbal',
    'Raza', 'Siddiqui', 'Qureshi', 'Javed', 'Aslam', 'Mirza', 'Chaudhry',
    'Sheikh', 'Nawaz', 'Abbasi', 'Hashmi', 'Dar'
];

const cities = [
    'Islamabad', 'Lahore', 'Karachi', 'Rawalpindi', 'Faisalabad',
    'Multan', 'Peshawar', 'Quetta', 'Sialkot', 'Hyderabad'
];

const categories = {
    'Electronics': {
        products: ['Wireless Earbuds', 'Smart Watch', 'Power Bank', 'USB Cable',
            'Phone Case', 'Bluetooth Speaker', 'Laptop Stand', 'Mouse', 'Keyboard', 'Webcam'],
        min: 500, max: 15000
    },
    'Clothing': {
        products: ['T-Shirt', 'Jeans', 'Kurta', 'Hoodie', 'Jacket',
            'Formal Shirt', 'Trouser', 'Sweater', 'Polo Shirt', 'Shorts'],
        min: 500, max: 5000
    },
    'Home & Kitchen': {
        products: ['Water Bottle', 'Lunch Box', 'Cooking Pan', 'Knife Set', 'Blender',
            'Mug Set', 'Cutting Board', 'Storage Container', 'Tea Set', 'Plate Set'],
        min: 300, max: 8000
    },
    'Books': {
        products: ['Python Programming', 'Data Science Guide', 'Fiction Novel', 'Self Help Book',
            'History Book', 'Science Book', 'Math Textbook', 'English Grammar', 'Islamic Studies', 'Business Book'],
        min: 200, max: 3000
    },
    'Beauty': {
        products: ['Face Wash', 'Moisturizer', 'Sunscreen', 'Hair Oil', 'Perfume',
            'Lip Balm', 'Face Mask', 'Shampoo', 'Body Lotion', 'Nail Polish'],
        min: 200, max: 4000
    },
    'Sports': {
        products: ['Cricket Ball', 'Football', 'Yoga Mat', 'Skipping Rope', 'Dumbbells',
            'Badminton Racket', 'Running Shoes', 'Gym Gloves', 'Sports Bottle', 'Sports Bag'],
        min: 300, max: 7000
    },
    'Toys': {
        products: ['Building Blocks', 'Board Game', 'Puzzle Set', 'Remote Car', 'Doll',
            'Action Figure', 'Color Set', 'Play Dough', 'Card Game', 'Stuffed Toy'],
        min: 200, max: 5000
    },
    'Food': {
        products: ['Dry Fruits Pack', 'Chocolate Box', 'Tea Pack', 'Coffee Beans', 'Honey Jar',
            'Spice Set', 'Biscuit Pack', 'Juice Box', 'Snack Pack', 'Rice Bag'],
        min: 100, max: 3000
    },
    'Health': {
        products: ['Vitamin Tablets', 'First Aid Kit', 'Mask Pack', 'Hand Sanitizer', 'Thermometer',
            'BP Monitor', 'Protein Powder', 'Omega 3 Capsules', 'Pain Relief Gel', 'Eye Drops'],
        min: 200, max: 5000
    },
    'Accessories': {
        products: ['Wallet', 'Belt', 'Sunglasses', 'Watch Strap', 'Backpack',
            'Scarf', 'Cap', 'Keychain', 'Ring', 'Bracelet'],
        min: 150, max: 4000
    }
};

const paymentMethods = ['Credit Card', 'Debit Card', 'Cash on Delivery', 'JazzCash', 'EasyPaisa'];
const devices = ['Mobile', 'Desktop', 'Tablet'];
const catNames = Object.keys(categories);

let customers = [];
for (let i = 1; i <= 300; i++) {
    let gender = Math.random() < 0.52 ? 'Male' : 'Female';
    let firstName = gender === 'Male' ? pick(maleNames) : pick(femaleNames);
    customers.push({
        id: 'C' + String(i).padStart(3, '0'),
        name: firstName + ' ' + pick(lastNames),
        age: randomInt(18, 65),
        gender: gender,
        city: pick(cities),
        regDate: randomDate('2023-01-01', '2024-06-30')
    });
}

let orders = [];
let orderId = 1;

for (let c of customers) {
    let numOrders = randomInt(3, 8);
    let prevPurchases = randomInt(0, 30);

    for (let j = 0; j < numOrders; j++) {
        let catName = pick(catNames);
        let cat = categories[catName];
        let product = pick(cat.products);
        let price = randomInt(cat.min, cat.max);
        let qty = randomInt(1, 4);
        let hasDiscount = Math.random() < 0.35;
        let discPct = hasDiscount ? pick([5, 10, 15, 20]) : 0;
        let total = Math.round(price * qty * (1 - discPct / 100));

        let satisfaction = randomInt(1, 5);
        if (hasDiscount && satisfaction < 4) satisfaction += 1;

        let session = randomInt(2, 60);
        let device;
        if (c.age < 30) {
            device = Math.random() < 0.6 ? 'Mobile' : pick(['Desktop', 'Tablet']);
        } else {
            device = pick(devices);
        }

        orders.push([
            c.id, c.name, c.age, c.gender, c.city, c.regDate,
            'ORD' + String(orderId).padStart(4, '0'),
            randomDate('2024-01-01', '2025-05-31'),
            catName, product, price, qty, total,
            pick(paymentMethods),
            hasDiscount ? 'Yes' : 'No',
            discPct, satisfaction, session, device,
            prevPurchases + j
        ]);
        orderId++;
    }
}

let header = 'customer_id,customer_name,age,gender,city,registration_date,order_id,order_date,product_category,product_name,unit_price,quantity,total_amount,payment_method,discount_applied,discount_percent,satisfaction_score,session_duration_min,device_type,num_previous_purchases';
let csv = header + '\n';
for (let row of orders) {
    csv += row.join(',') + '\n';
}

fs.writeFileSync(path.join(datasetDir, 'ecommerce_data.csv'), csv);
console.log('Done! Generated ' + orders.length + ' records.');
console.log('File saved: dataset/ecommerce_data.csv');
