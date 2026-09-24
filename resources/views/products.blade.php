<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Products — MarketLink</title>
  <link rel="stylesheet" href="{{ asset('website/css/products.css') }}">
</head>
<body>

  {{-- HEADER + HERO --}}
  <header class="site-header" style="background-image: url('{{ asset('images/backgrounds/products-hero-bg.png') }}');">
    <div class="hero-overlay"></div>

    <nav class="navbar">
      <a href="/" class="logo">
        <img src="{{ asset('images/logo/logo-mark.png') }}" alt="MarketLink">
        MarketLink
      </a>

      <div class="nav-links">
        <a href="#">Markets</a>
        <a href="{{ route('products') }}" class="active">Products</a>
        <a href="#">Farmers</a>
        <a href="#">Events</a>
        <a href="#">About</a>
      </div>

      <div class="nav-actions">
        <a href="#" class="btn-login">Login</a>
        <a href="#" class="btn-signup">Sign Up</a>
      </div>
    </nav>

    <div class="hero-content">
      <h1>Fresh Produce</h1>
      <p>Browse products from local farmers and markets near you.</p>

      <form action="{{ route('products') }}" method="GET" class="search-form">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products, farmers, or markets...">
        <button type="submit" aria-label="Search">
          <img src="{{ asset('images/icons/icon-search-white.png') }}" alt="">
        </button>
      </form>
    </div>
  </header>

  {{-- CATEGORY CHIPS --}}
  <div class="category-bar">
    <div class="chips">
      @php
        $activeCategory = request('category', 'all');
        $chips = [
          'all'          => 'All',
          'vegetables'   => 'Vegetables',
          'fruits'       => 'Fruits',
          'dairy'        => 'Dairy',
          'baked-goods'  => 'Baked Goods',
          'herbs-spices' => 'Herbs & Spices',
          'organic'      => 'Organic',
        ];
      @endphp
      @foreach ($chips as $slug => $label)
        <a href="{{ route('products', array_filter(['category' => $slug === 'all' ? null : $slug, 'q' => request('q')])) }}"
           class="chip {{ $activeCategory === $slug ? 'active' : '' }}">
          {{ $label }}
        </a>
      @endforeach
    </div>
  </div>

  {{-- PRODUCT GRID --}}
  <section class="products-section">
    @php
      // Sample data — asal project mein controller se $products bhejna:
      // return view('products', ['products' => Product::with('farmer')->paginate(12)]);
      $sampleProducts = [
        ['slug' => 'tomatoes',    'name' => 'Vine Tomatoes',    'price' => 'Rs 180 / kg', 'market' => 'Market Market'],
        ['slug' => 'carrots',     'name' => 'Fresh Carrots',    'price' => 'Rs 120 / kg', 'market' => 'Market Market'],
        ['slug' => 'leafy-greens','name' => 'Leafy Greens Mix', 'price' => 'Rs 150 / kg', 'market' => 'Herbs Market'],
        ['slug' => 'apples',      'name' => 'Red Apples',       'price' => 'Rs 220 / kg', 'market' => 'Market Market'],
        ['slug' => 'oranges',     'name' => 'Sweet Oranges',    'price' => 'Rs 190 / kg', 'market' => 'Market Market'],
        ['slug' => 'milk',        'name' => 'Farm Fresh Milk',  'price' => 'Rs 210 / L',  'market' => 'Herbs Market'],
        ['slug' => 'sourdough',   'name' => 'Sourdough Loaf',   'price' => 'Rs 350 / pc', 'market' => 'Market Market'],
        ['slug' => 'basil',       'name' => 'Fresh Basil',      'price' => 'Rs 80 / bunch','market' => 'Herbs Market'],
      ];
    @endphp

    <div class="products-toolbar">
      <span>{{ count($sampleProducts) }} products</span>

      <form action="{{ route('products') }}" method="GET">
        <input type="hidden" name="category" value="{{ request('category') }}">
        <input type="hidden" name="q" value="{{ request('q') }}">
        <select name="sort" id="sort-select">
          <option value="popular" @selected(request('sort') === 'popular')>Most Popular</option>
          <option value="price-asc" @selected(request('sort') === 'price-asc')>Price: Low to High</option>
          <option value="price-desc" @selected(request('sort') === 'price-desc')>Price: High to Low</option>
          <option value="newest" @selected(request('sort') === 'newest')>Newest</option>
        </select>
      </form>
    </div>

    <div class="products-grid">
      @foreach ($sampleProducts as $product)
        <a href="#" class="product-card">
          <div class="thumb">
            <img src="{{ asset('images/products/product-' . $product['slug'] . '.jpg') }}" alt="{{ $product['name'] }}">
          </div>
          <div class="info">
            <p class="name">{{ $product['name'] }}</p>
            <p class="market">{{ $product['market'] }}</p>
            <div class="row">
              <span class="price">{{ $product['price'] }}</span>
              <span class="add">Add</span>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    <div class="pagination">
      <span class="page active">1</span>
      <span class="page">2</span>
      <span class="page">3</span>
      <span>→</span>
    </div>
  </section>

  {{-- FOOTER --}}
  <footer class="site-footer">
    <div class="footer-inner">
      <span class="footer-brand">MarketLink</span>

      <div class="footer-links">
        <a href="#">About</a>
        <a href="#">Markets</a>
        <a href="{{ route('products') }}">Products</a>
        <a href="#">Farmers</a>
        <a href="#">Events</a>
        <a href="#">Contact</a>
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
      </div>

      <div class="footer-social">
        <a href="#"><img src="{{ asset('images/icons/icon-facebook.png') }}" alt="Facebook"></a>
        <a href="#"><img src="{{ asset('images/icons/icon-instagram.png') }}" alt="Instagram"></a>
        <a href="#"><img src="{{ asset('images/icons/icon-twitter.png') }}" alt="Twitter"></a>
      </div>
    </div>
  </footer>

  <script src="{{ asset('website/js/products.js') }}"></script>
</body>
</html>