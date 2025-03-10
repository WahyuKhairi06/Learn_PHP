<?php
$data = [
    "name" => "Wahyu Khairi",
    "nim" => "TI12345",
    "major" => "Informatika",
    "semester" => 4,
    "subjects" => [
        [
            "code" => "IF2101",
            "name" => "Pemrograman Web",
            "sks" => 3,
            "grades" => [
                "assigment" => 85,
                "uts" => 78,
                "uas" => 88
            ]
        ],
        [
            "code" => "IF2102",
            "name" => "Algoritma dan Struktur Data",
            "sks" => 4,
            "grades" => [
                "assigment" => 90,
                "uts" => 85,
                "uas" => 82
            ]
        ],
        [
            "code" => "IF2103",
            "name" => "Basis Data",
            "sks" => 3,
            "grades" => [
                "assigment" => 78,
                "uts" => 75,
                "uas" => 80
            ]
        ],
        [
            "code" => "IF2104",
            "name" => "Jaringan Komputer",
            "sks" => 3,
            "grades" => [
                "assigment" => 88,
                "uts" => 70,
                "uas" => 75
            ]
        ],
        [
            "code" => "IF2105",
            "name" => "Sistem Operasi",
            "sks" => 3,
            "grades" => [
                "assigment" => 95,
                "uts" => 90,
                "uas" => 92
            ]
        ],
        [
            "code" => "IF2106",
            "name" => "Matematika Diskrit",
            "sks" => 2,
            "grades" => [
                "assigment" => 75,
                "uts" => 68,
                "uas" => 70
            ]
        ]
    ]
];


function NilaiAkhir($grades) {
    $total = (0.2 * $grades['assigment']) + (0.4 * $grades['uts']) + (0.4 * $grades['uas']);
    return $total;
}

function CalculateGrade($average) {
    if ($average >= 85) {
        return "A";
    } elseif ($average >= 80) {
        return "A-";
    } elseif ($average >= 75) {
        return "B+";
    } elseif ($average >= 70) {
        return "B";
    } elseif ($average >= 65) {
        return "B-";
    } elseif ($average >= 60) {
        return "C+";
    } elseif ($average >= 55) {
        return "C";
    } elseif ($average >= 45) {
        return "D";
    } else {
        return "E";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .container {
            display: flex;
            justify-content: space-between;
            padding: 3%;
        
        }
        .left-column {
            width: 48%;  
        }
        .right-column {
            width: 48%;
            text-align: right; 
        }   
        
    </style>
</head>
<body>
    <h2 align="center">Kartu Hasil Studi </h2>
    <div class="container">
  <div class="left-column">
    <p><strong>Nama:</strong> <?= htmlspecialchars($data["name"]) ?></p>
    <p><strong>NIM:</strong> <?= htmlspecialchars($data["nim"]) ?></p>
  </div>

  <div class="right-column">
    <p><strong>Major:</strong> <?= htmlspecialchars($data["major"]) ?></p>
    <p><strong>Semester:</strong> <?= $data["semester"] ?></p>
  </div>
</div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Tugas (20%)</th>
                <th>UTS (40%)</th>
                <th>UAS (40%)</th>
                <th>Nilai Akhir</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data["subjects"] as $subject): 
                $average = NilaiAkhir($subject["grades"]);
                $grade = CalculateGrade($average);
            ?>
                <tr>
                    <td><?= htmlspecialchars($subject["code"]) ?></td>
                    <td><?= htmlspecialchars($subject["name"]) ?></td>
                    <td><?= $subject["sks"] ?></td>
                    <td><?= $subject["grades"]["assigment"] ?></td>
                    <td><?= $subject["grades"]["uts"] ?></td>
                    <td><?= $subject["grades"]["uas"] ?></td>
                    <td><?= number_format($average, 2) ?></td>
                    <td><?= $grade ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
