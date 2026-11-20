
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Persetujuan</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            color: #000;
            margin: 40px auto;
            padding: 0 35px;
            max-width: 850px;
            line-height: 1.5;
        }

        /* KOP SURAT */
        .header {
            border-bottom: 4px double #000;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-table td {
            border: none;
            padding: 2px 5px;
            vertical-align: middle;
        }

        .logo {
            width: 105px;
            text-align: center;
        }

        .logo img {
            width: 85px;
            height: 85px;
            object-fit: contain;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h2,
        .kop-text h3,
        .kop-text p {
            margin: 1px 0;
        }

        .kop-text h3 {
            font-size: 14pt;
            font-weight: normal;
        }

        .kop-text h2 {
            font-size: 17pt;
            font-weight: bold;
        }

        .kop-text p {
            font-size: 10pt;
        }

        /* JUDUL SURAT */
        .title {
            text-align: center;
            margin: 28px 0;
        }

        .title h3 {
            text-decoration: underline;
            margin-bottom: 4px;
        }

        .title p {
            margin-top: 4px;
        }

        /* ISI SURAT */
        .content {
            text-align: justify;
        }

        table.data {
            margin: 14px 0 14px 25px;
            border-collapse: collapse;
        }

        table.data td {
            padding: 3px 8px;
            vertical-align: top;
        }

        /* TANDA TANGAN */
        .signature {
            width: 260px;
            margin: 45px 0 0 auto;
            text-align: center;
        }

        .signature .name {
            margin-top: 75px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* TOMBOL CETAK */
        .actions {
            text-align: center;
            margin-bottom: 25px;
        }

        .actions button {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background: #198754;
            color: white;
            font-size: 14px;
        }

        @media print {
            @page {
                size: A4;
                margin: 20mm;
            }

            body {
                max-width: none;
                margin: 0;
                padding: 0;
            }

            .actions {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- TOMBOL CETAK -->
    <div class="actions">
        <button onclick="window.print()">Cetak Surat</button>
    </div>

    <!-- KOP SURAT -->
    <div class="header">
        <table class="kop-table">
            <tr>
                <td class="logo">
                    <img
                        src="{{ asset('images/logo_kediri.png') }}"
                        alt="Logo Kabupaten Kediri"
                    >
                </td>

                <td class="kop-text">
                    <h3>PEMERINTAH KABUPATEN KEDIRI</h3>
                    <h3>KECAMATAN PLOSOKLATEN</h3>
                    <h2>PEMERINTAH DESA JARAK</h2>
                    <p>
                        Alamat: [Alamat Resmi Kantor Desa Jarak]
                    </p>
                    <p>
                        Email: desajarak204@gmail.com
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <!-- JUDUL SURAT -->
    <div class="title">
        <h3>SURAT KETERANGAN PERSETUJUAN</h3>
        <p>Nomor: [Nomor Surat]</p>
    </div>

    <!-- ISI SURAT -->
    <div class="content">

        <p>Yang bertanda tangan di bawah ini:</p>

        <table class="data">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>[Nama Kepala Desa / Pejabat Berwenang]</td>
            </tr>

            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>Kepala Desa Jarak</td>
            </tr>
        </table>

        <p>
            Dengan ini menerangkan bahwa permohonan kerja sama/kegiatan
            berikut:
        </p>

        <table class="data">
            <tr>
                <td>Nama Pemohon</td>
                <td>:</td>
                <td>{{ $pengajuan->nama_lengkap }}</td>
            </tr>

            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>{{ $pengajuan->nim ?: '-' }}</td>
            </tr>

            <tr>
                <td>Instansi</td>
                <td>:</td>
                <td>{{ $pengajuan->nama_instansi }}</td>
            </tr>

            <tr>
                <td>Program Studi</td>
                <td>:</td>
                <td>{{ $pengajuan->program_studi ?: '-' }}</td>
            </tr>

            <tr>
                <td>Jenis Kegiatan</td>
                <td>:</td>
                <td>{{ $pengajuan->jenis_kegiatan }}</td>
            </tr>

            <tr>
                <td>Judul Kegiatan</td>
                <td>:</td>
                <td>{{ $pengajuan->judul_kerjasama }}</td>
            </tr>

            <tr>
                <td>Waktu Pelaksanaan</td>
                <td>:</td>
                <td>
                    {{ $pengajuan->tanggal_mulai?->format('d-m-Y') ?: '-' }}
                    s.d.
                    {{ $pengajuan->tanggal_selesai?->format('d-m-Y') ?: '-' }}
                </td>
            </tr>
        </table>

        <p>
            Berdasarkan permohonan yang telah diajukan, Pemerintah Desa Jarak
            menyatakan bahwa permohonan tersebut
            <strong>DISETUJUI</strong> untuk dilaksanakan dengan tetap
            memperhatikan ketentuan dan koordinasi yang berlaku di lingkungan
            Pemerintah Desa Jarak.
        </p>

        <p>
            Demikian surat keterangan persetujuan ini dibuat agar dapat
            dipergunakan sebagaimana mestinya.
        </p>

    </div>

    <!-- TANDA TANGAN -->
    <div class="signature">
        <p>
            Jarak, {{ now()->translatedFormat('d F Y') }}
        </p>

        <p>Kepala Desa Jarak</p>

        <div class="name">
            [Moh Toha]
        </div>
    </div>

</body>
</html>
