<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        :root {
            --link: #000;
            --hover: #fbbf24;
            --main: #fff;
            --bg: #09090b;
            --size: 99vmin;
            --ratio: 1/1.1;
            /* font-size: calc(var(--size)/100); */
        }

        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: var(--bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--main);
        }

        a {
            text-decoration: none;
            color: var(--main);
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 900;
            padding: 40px 0;
        }

        .container {
            width: calc(var(--size)*var(--ratio));
            margin: 0 auto;
        }

        .logo {
            width: 190px;
            padding: 10px 0;
            cursor: pointer;
            position: relative;
            text-align: center;
            border: 3px solid var(--main);
            color: var(--main);
            font-size: 2.2rem;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 2.5px;
            transition: all 0.2s;
        }

        .logo:hover {
            background: var(--hover);
            color: var(--bg);
            border-color: var(--hover);
        }

        nav {
            display: flex;
        }

        nav {
            display: inline-block;
            color: #000;
            font-size: 1rem;
            font-weight: bold;
            text-transform: uppercase;
            margin-right: 10px;
            padding: 4px 10px;
            transition: all 300ms ease-in-out;
        }

        nav a:hover {
            color: var(--hover);
        }

        .intro {
            width: 100%;
            text-align: center;
            overflow: hidden;
            font-size: .9rem;
            text-transform: uppercase;
            font-weight: bold;
        }

        .intro-title {
            color: var(--main);
            font-size: 3rem;
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 10vmin;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            text-align: center;
            border: 1px solid var(--main);
            cursor: pointer;
            transition: all 300ms ease-in-out;
        }

        .btn:hover {
            background-color: var(--hover);
            color: var(--bg);
            border-color: var(--hover);
        }
    </style>
</head>

<body>
    <header class="container">
        <a href="" class="logo">INVOICE</a>
        <nav>
            @auth
                <a href="{{ url('admin') }}">Dashboard</a>
            @endauth
            <a href="#tentang">Tentang</a>
            @auth
                <a href="#" id="btn-logout">Logout</a>
                <form action="{{ url('/admin/logout') }}" method="post" id="form-logout">
                    {{ csrf_field() }}
                </form>
            @endauth
        </nav>
    </header>
    <div class="container">
        <div class="intro">
            <h1 class="intro-title">Invoice <br> Sederhana</h1>
            <p>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. A voluptas hic earum cum?
            </p>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempore nisi numquam aliquid facilis ducimus
            </p>
            <br>
            @auth
                <a href="{{ url('admin') }}" class="btn">Dashboard</a>
            @else
                <a href="{{ url('admin/login') }}" class="btn">Login Here</a>
            @endauth
        </div>
    </div>
    <script>
        var form = document.getElementById("form-logout");
        document.getElementById("btn-logout").addEventListener("click", function() {
            form.submit();
        });
    </script>
</body>

</html>
