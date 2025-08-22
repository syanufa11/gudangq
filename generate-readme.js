const fs = require("fs");
const path = require("path");

// Folder utama CodeIgniter
const baseDir = path.join(__dirname, "app");
const screenshotDir = path.join(__dirname, "screenshoot");

// Folder/berkas penting yang ingin ditampilkan
const importantDirs = [
  "Controllers",
  "Models",
  "Views",
  "Database",
  "Config",
  "Helpers",
];
const importantFiles = [".env", "composer.json", "spark"];

function readAppFolder(dir, indent = "") {
  let result = "app/\n";
  const files = fs.readdirSync(dir);
  files.forEach((file) => {
    const fullPath = path.join(dir, file);
    if (fs.statSync(fullPath).isDirectory() && importantDirs.includes(file)) {
      result += `${indent}  ${file}/\n`;
      const subFiles = fs.readdirSync(fullPath);
      subFiles.forEach((sub) => {
        result += `${indent}    ${sub}\n`;
      });
    }
  });
  return result;
}

function readRootFiles() {
  let result = "";
  importantFiles.forEach((file) => {
    if (fs.existsSync(path.join(__dirname, file))) {
      result += `${file}\n`;
    }
  });
  return result;
}

// Struktur folder (ringkas)
const structure = `${readAppFolder(baseDir)}${readRootFiles()}`;

// Ambil semua file gambar dari folder screenshoot
let screenshotSection = "";
if (fs.existsSync(screenshotDir)) {
  const images = fs.readdirSync(screenshotDir).filter((file) => {
    return /\.(png|jpg|jpeg|gif)$/i.test(file);
  });
  if (images.length > 0) {
    screenshotSection = "## Screenshoot\n\n";
    images.forEach((img) => {
      screenshotSection += `![${img}](screenshoot/${img})\n\n`;
    });
  }
}

// Konten README
const readmeContent = `
# Sistem Manajemen Gudang Sederhana

## Deskripsi Umum
Aplikasi ini dibuat menggunakan **CodeIgniter 4** untuk mencatat barang masuk, keluar, pembelian, dan memantau stok barang.

---

## ⚙️ Penjelasan Fitur

### 🔑 Login
- Autentikasi menggunakan email/username dan password.
- Role menentukan hak akses (Admin, User, dsb).

### 👤 Profile
- Menampilkan data pengguna.
- Fitur edit profil sesuai user yang sedang login.

### 🔒 Ubah Password
- Mengganti password lama dengan password baru.

### 🏷️ Aplikasi
- Mengubah nama aplikasi dan logo sesuai kebutuhan.

### 🛡️ CRUD Role User
- Tambah, ubah, hapus role user.
- Digunakan untuk mengatur level akses.

### 👥 CRUD User
- Manajemen user (tambah, ubah, hapus).
- Set role untuk masing-masing user.

### 📊 Dashboard
- Menampilkan ringkasan:
  - Total kategori
  - Total barang tersedia
  - Total barang masuk
  - Total barang keluar
- Grafik barang masuk & keluar
- Stok per kategori
- Data pembelian

### 📦 Kategori
- CRUD kategori barang.

### 📦 Barang
- CRUD data barang.

### 🛒 Pembelian Barang
- Input data pembelian barang.
- Fitur cetak PDF nota pembelian.

### 📥📤 Transaksi Barang Masuk & Keluar
- Mencatat transaksi barang masuk dan keluar.

### 📑 Laporan Barang Masuk & Keluar
- Laporan dapat difilter berdasarkan tanggal.
- Ekspor laporan ke **Excel, PDF, dan Word**.

---

## Struktur Project
\`\`\`
${structure}
\`\`\`

---

## ⚙️ Instalasi

### Teknologi
- Framework: CodeIgniter 4
- Database: MySQL
- Frontend: Bootstrap

### Persyaratan
- PHP >= 8.1
- Composer
- MySQL

### Langkah-langkah
1. Clone repo:
\`\`\`bash
git clone <link-repo>
cd <folder-project>
\`\`\`

2. Install dependencies:
\`\`\`bash
composer install
\`\`\`

3. Copy file **.env.example** jadi **.env**, lalu sesuaikan konfigurasi database.

4. Import database (pilih salah satu cara):  
   - **Cara 1**: Import file SQL yang sudah tersedia ke MySQL/XAMPP.  
   - **Cara 2**: Jalankan migrate (jika belum import SQL):  
     \`\`\`bash
     php spark migrate
     php spark db:seed RoleSeeder
     php spark db:seed UserSeeder
     \`\`\`

   > Seeder hanya dijalankan jika database masih kosong. SQL bawaan sudah ada data role dan user.

5. Jalankan server:
\`\`\`bash
php spark serve
\`\`\`

---

## Akses Login
Gunakan akun berikut untuk masuk ke sistem:

- **Username**: \`admin\`  
- **Password**: \`admin\`

---

## 📌 Tantangan Selama Pengerjaan dan Cara Menyelesaikannya

Selama pengembangan aplikasi ini, terdapat beberapa tantangan yang dihadapi, di antaranya:

1. **Manajemen Relasi Database**  
   - Tantangan: Menentukan relasi antar tabel (user, role, barang, kategori, transaksi) agar tidak terjadi inkonsistensi data.  
   - Solusi: Mendesain ERD terlebih dahulu dan menggunakan migration serta seeder untuk menjaga konsistensi data.

2. **Otentikasi & Hak Akses**  
   - Tantangan: Memastikan hanya user dengan role tertentu yang bisa mengakses fitur tertentu.  
   - Solusi: Implementasi middleware dan sistem role-based access control (RBAC).

3. **Laporan Multi-format (Excel, PDF, Word)**  
   - Tantangan: Membuat laporan barang masuk/keluar dalam berbagai format.  
   - Solusi: Menggunakan library pihak ketiga (PhpSpreadsheet & Dompdf) untuk mendukung ekspor data.

4. **Visualisasi Data pada Dashboard**  
   - Tantangan: Menyajikan data barang masuk/keluar dalam bentuk grafik agar mudah dipahami.  
   - Solusi: Integrasi dengan chart library (misalnya ApexCharts) untuk visualisasi data.

5. **Pengelolaan File (Logo Aplikasi & Cetak PDF)**  
   - Tantangan: Mengatur upload dan penyimpanan file logo aplikasi serta file cetakan transaksi.  
   - Solusi: Menambahkan validasi file upload dan menggunakan helper untuk proses generate PDF.


---

${screenshotSection}

`;

fs.writeFileSync("README.md", readmeContent);
console.log("README.md berhasil dibuat!");
