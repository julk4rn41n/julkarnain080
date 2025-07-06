<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konversi Suhu Interaktif</title>
</head>
<body>
<!-- Form utama (gunakan method POST agar bisa diakses PHP) -->
<form method="post" class="container">
    <h2>Kalkulator Konversi Suhu 🌡️</h2>

    <!-- Input 1 -->
    <input type="number" name="nilai1" id="input1" placeholder="Masukkan suhu"
      value="<?= isset($_POST['nilai1']) ? htmlspecialchars($_POST['nilai1']) : '' ?>">
    <select name="from" id="select1">
        <option value="celsius" <?= (isset($_POST['from']) && $_POST['from'] == 'celsius') ? 'selected' : '' ?>>Celsius (°C)</option>
        <option value="fahrenheit" <?= (isset($_POST['from']) && $_POST['from'] == 'fahrenheit') ? 'selected' : '' ?>>Fahrenheit (°F)</option>
    </select>

    <!-- Input 2 -->
    <input type="number" id="input2" placeholder="Masukkan suhu" readonly>
    <select name="to" id="select2">
        <option value="fahrenheit" <?= (isset($_POST['to']) && $_POST['to'] == 'fahrenheit') ? 'selected' : '' ?>>Fahrenheit (°F)</option>
        <option value="celsius" <?= (isset($_POST['to']) && $_POST['to'] == 'celsius') ? 'selected' : '' ?>>Celsius (°C)</option>
    </select>

    <br><input type="submit" value="Tampilkan Hasil Konversi dengan PHP">
  </form>

  <!-- Output dari PHP -->
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nilai = isset($_POST["nilai1"]) ? floatval($_POST["nilai1"]) : 0;
      $dari = $_POST["from"] ?? '';
      $ke = $_POST["to"] ?? '';
      $hasil = 0;

      if ($dari == $ke) {
          $hasil = $nilai;
      } elseif ($dari == "celsius" && $ke == "fahrenheit") {
          $hasil = ($nilai * 9 / 5) + 32;
      } elseif ($dari == "fahrenheit" && $ke == "celsius") {
          $hasil = ($nilai - 32) * 5 / 9;
      }

      echo "<div class='php-output'>Hasil PHP: {$nilai}°" . strtoupper($dari[0]) . " = " . round($hasil, 2) . "°" . strtoupper($ke[0]) . "</div>";
  }
  ?>
<script>
    const input1 = document.getElementById("input1");
    const input2 = document.getElementById("input2");
    const select1 = document.getElementById("select1");
    const select2 = document.getElementById("select2");

    let sedangMengubah = false;

    function konversi(inputValue, from, to) {
        if (from === to) return inputValue;
        if (from === "celsius" && to === "fahrenheit") {
            return (inputValue * 9 / 5) + 32;
        } else if (from === "fahrenheit" && to === "celsius") {
            return (inputValue - 32) * 5 / 9;
        }
        return null;
        }

    input1.addEventListener("input", function () {
        if (sedangMengubah) return;
        sedangMengubah = true;

        const val = parseFloat(input1.value);
        const from = select1.value;
        const to = select2.value;

        if (!isNaN(val)) {
            const hasilKonversi = konversi(val, from, to);
            input2.value = hasilKonversi.toFixed(2);
        } else {
            input2.value = "";
        }

        sedangMengubah = false;
    });

    input2.addEventListener("input", function () {
        if (sedangMengubah) return;
        sedangMengubah = true;

        const val = parseFloat(input2.value);
        const from = select2.value;
        const to = select1.value;

        if (!isNaN(val)) {
        const hasilKonversi = konversi(val, from, to);
        input1.value = hasilKonversi.toFixed(2);
        } else {
        input1.value = "";
        }

        sedangMengubah = false;
    });
</script>
 

 

</body>
</html>