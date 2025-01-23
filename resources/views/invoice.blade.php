<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Laralink">
    <!-- Site Title -->
    <title>Invoice #{{ $invoice_no }}</title>
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
    <style>
        .status {
            font-size: 100px;
            font-weight: bold;
            border-radius: 10px;
            border-style: solid;
            border-width: 8px;
            text-align: center;
            position: absolute;
            top: 35%;
            left: 25%;
            width: 500px;
            opacity: 20%;
            rotate: -30deg;
            z-index: 999;
        }

        .unpaid {
            color: red;
            border-color: red;
        }

        .paid {
            color: green;
            border-color: green;
        }
    </style>
</head>

<body>
    <div class="tm_container">
        <div class="tm_invoice_wrap">
            <div class="tm_invoice tm_style2" id="tm_download_section">
                <div class="status {{ strtolower($data->status) }}">
                    {{ strtoupper($data->status) }}
                </div>
                <div class="tm_invoice_in">
                    <div class="tm_invoice_head tm_top_head tm_mb20">
                        <div class="tm_invoice_left">
                            <div class="tm_logo">
                                <img src="{{ asset('logo.png') }}" alt="Logo">
                            </div>
                            <div style="font-size:1.5em;color:#fe6006;font-weight:bold;">
                                {{ $user->name }}
                            </div>
                        </div>
                        <div class="tm_invoice_right">
                            <div class="tm_grid_row tm_col_3">
                                <div>
                                    <b class="tm_primary_color">Email</b> <br>
                                    {{ $user->email }}
                                </div>
                                <div>
                                    <b class="tm_primary_color">Telepon</b> <br>
                                    {{ $user->phone }}
                                </div>
                                <div>
                                    <b class="tm_primary_color">Alamat</b> <br>
                                    {!! $user->address !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tm_invoice_info tm_mb10">
                        <div class="tm_invoice_info_left">
                            <p class="tm_mb2"><b>Kepada:</b></p>
                            <p>
                                <b class="tm_f16 tm_primary_color">{{ $data->client->nama }}</b> <br>
                                {{ $data->client->lembaga }}<br>
                                {{ $data->client->alamat }}<br>
                                {{ $data->client->hp }}<br>
                                {{ $data->client->email }}
                            </p>
                        </div>
                        <div class="tm_invoice_info_right">
                            <div
                                class="tm_ternary_color tm_f50 tm_text_uppercase tm_text_center tm_invoice_title tm_mb15 tm_mobile_hide">
                                Invoice</div>
                            <div class="tm_grid_row tm_col_3 tm_invoice_info_in tm_accent_bg">
                                <div>
                                    <span class="tm_white_color_60">Total Tagihan:</span> <br>
                                    <b class="tm_f16 tm_white_color">Rp
                                        {{ number_format($data->total, 0, ',', '.') }}
                                    </b>
                                </div>
                                <div>
                                    <span class="tm_white_color_60">Tanggal:</span> <br>
                                    <b class="tm_f16 tm_white_color">{{ date('d F Y', strtotime($data->tanggal)) }}</b>
                                </div>
                                <div>
                                    <span class="tm_white_color_60">No Invoice:</span> <br>
                                    <b class="tm_f16 tm_white_color">#{{ $invoice_no }}
                                    </b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tm_table tm_style1">
                        <div class="tm_round_border">
                            <div class="tm_table_responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="tm_width_7 tm_semi_bold tm_accent_color">Nama</th>
                                            <th class="tm_width_2 tm_semi_bold tm_accent_color">Harga</th>
                                            <th class="tm_width_1 tm_semi_bold tm_accent_color">Jml</th>
                                            <th class="tm_width_2 tm_semi_bold tm_accent_color tm_text_right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $subtotal = 0;
                                        @endphp
                                        @foreach ($data['items'] as $i)
                                            <tr class="tm_gray_bg">
                                                <td class="tm_width_7">
                                                    <p class="tm_m0 tm_f16 tm_primary_color">
                                                        {{ $i['nama'] }}
                                                    </p>
                                                    {{ $i['keterangan'] ?? '' }}
                                                </td>
                                                <td class="tm_width_2">Rp{{ number_format($i['harga'], 0, ',', '.') }}
                                                </td>
                                                <td class="tm_width_1">{{ $i['jumlah'] }}</td>
                                                <td class="tm_width_2 tm_text_right">
                                                    Rp{{ number_format($i['harga'] * $i['jumlah'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            @php
                                                $subtotal += $i['harga'] * $i['jumlah'];
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tm_invoice_footer tm_mb6 tm_m0_md">
                            <div class="tm_left_footer">
                                <div class="tm_card_note tm_ternary_bg tm_white_color">
                                    <b>Pembayaran: </b>
                                    BCA
                                    - 322 049 0938 a/n: Ahsanul Muadib
                                </div>
                                <p class="tm_mb2"><b class="tm_primary_color">Catatan:</b></p>
                                <p class="tm_m0">
                                    {!! $data['keterangan'] ?? '-' !!}
                                </p>
                            </div>
                            <div class="tm_right_footer">
                                <table class="tm_mb15">
                                    <tbody>
                                        <tr>
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Subtotal</td>
                                            <td
                                                class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">
                                                Rp{{ number_format($subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tm_width_3 tm_danger_color tm_border_none tm_pt0">Diskon 0%
                                            </td>
                                            <td class="tm_width_3 tm_danger_color tm_text_right tm_border_none tm_pt0">
                                                -Rp0</td>
                                        </tr>
                                        <tr>
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Pajak 0%</td>
                                            <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">
                                                +$0</td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_white_color tm_accent_bg tm_radius_6_0_0_6">
                                                Total Tagihan</td>
                                            <td
                                                class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color tm_text_right tm_white_color tm_accent_bg tm_radius_0_6_6_0">
                                                Rp{{ number_format($subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tm_invoice_footer tm_type1">
                            <div class="tm_left_footer"></div>
                            <div class="tm_right_footer">
                                <div class="tm_sign tm_text_center">
                                    <img src="{{ asset('/sign.png') }}" alt="Sign">
                                    {{-- <p class="tm_m0 tm_ternary_color">Ahsanul Mu'adib</p> --}}
                                    {{-- <p class="tm_m0 tm_f16 tm_primary_color">Accounts Manager</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tm_note tm_font_style_normal tm_text_center">
                        <hr class="tm_mb15">
                        <p class="tm_mb2"><b class="tm_primary_color">Syarat &amp; Ketentuan:</b></p>
                        <p class="tm_m0">
                            Semua klaim yang berhubungan dengan kesalahan kuantitas atau pengiriman akan diabaikan
                            kecuali disampaikan dalam waktu tiga puluh (30) hari
                            setelah tanggal yang tertera dalam Invoice ini.
                        </p>
                    </div>

                </div>
            </div>
            <div class="tm_invoice_btns tm_hide_print">
                <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path
                                d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24"
                                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32">
                            </path>
                            <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32"
                                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32">
                            </rect>
                            <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none"
                                stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path>
                            <circle cx="392" cy="184" r="24" fill="currentColor"></circle>
                        </svg>
                    </span>
                    <span class="tm_btn_text">Print</span>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
