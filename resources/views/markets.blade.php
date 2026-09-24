<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Markets — MarketLink</title>
  <link rel="stylesheet" href="{{ asset('website/css/markets.css') }}">
</head>
<body>

  {{-- HEADER + HERO — same background-image pattern as the Products page --}}
  <header class="site-header" style="background-image: url('{{ asset('images/backgrounds/products-hero-bg.png') }}');">
    <div class="hero-overlay"></div>

    <nav class="navbar">
      <a href="/" class="logo">
        <img src="{{ asset('images/logo/logo-mark.png') }}" alt="MarketLink">
        MarketLink
      </a>

      <div class="nav-links">
        <a href="{{ route('markets') }}" class="active">Markets</a>
        <a href="{{ route('products') }}">Products</a>
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
      <h1>Discover Local Markets</h1>
      <p>Find fresh produce and local farmers near you.</p>

      <form action="{{ route('markets') }}" method="GET" class="search-form">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search markets by name or location...">
        <button type="submit" aria-label="Search">
          <img src="{{ asset('images/icons/icon-search-white.png') }}" alt="">
        </button>
      </form>
    </div>
  </header>

  <div class="wrap">

    {{-- FILTERS + MAP --}}
    <div class="markets-layout">
      <aside class="filters-card">
        <form action="{{ route('markets') }}" method="GET">
          <div class="filter-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="{{ request('location') }}" placeholder="Enter your location">
          </div>

          <div class="filter-group">
            <label for="distance">Distance</label>
            <input type="range" id="distance" name="distance" min="1" max="50" value="{{ request('distance', 10) }}">
          </div>

          <div class="filter-group">
            <label>Market days</label>
            <div class="day-chips">
              @foreach (['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'] as $day)
                <span class="day-chip">{{ $day }}</span>
              @endforeach
            </div>
          </div>

          <div class="filter-group">
            <label for="hours">Opening hours</label>
            <select id="hours" name="hours">
              <option value="">Any time</option>
              <option value="morning">Morning (6am – 12pm)</option>
              <option value="afternoon">Afternoon (12pm – 6pm)</option>
              <option value="evening">Evening (6pm – 10pm)</option>
            </select>
          </div>

          <div class="filter-group">
            <label>Product categories</label>
            @foreach (['Vegetables', 'Fruits', 'Dairy', 'Baked Goods', 'Herbs & Spices', 'Organic'] as $category)
              <div class="checkbox-row">
                <input type="checkbox" id="cat-{{ \Illuminate\Support\Str::slug($category) }}" name="categories[]" value="{{ \Illuminate\Support\Str::slug($category) }}">
                <label for="cat-{{ \Illuminate\Support\Str::slug($category) }}" style="margin:0;text-transform:none;font-size:13px;font-weight:400;color:inherit;">{{ $category }}</label>
              </div>
            @endforeach
          </div>

          <div class="filter-group">
            <div class="checkbox-row">
              <input type="checkbox" id="open-now" name="open_now" value="1">
              <label for="open-now" style="margin:0;text-transform:none;font-size:13px;font-weight:400;color:inherit;">Open now</label>
            </div>
          </div>

          <button type="submit" class="filter-submit">Apply Filters</button>
        </form>
      </aside>

      {{-- Map: only a sized container + <img> is set up. Drop a real
           map export/screenshot at images/markets/map-preview.png and
           it will fill this card correctly on its own. --}}
      <div class="map-card">
        <img src="{{ asset('images/markets/map-preview.png') }}" alt="Map of nearby markets">
        <div class="map-controls">
          <button type="button" aria-label="Zoom in">+</button>
          <button type="button" aria-label="Zoom out">−</button>
        </div>
      </div>
    </div>

    {{-- MARKET CARDS GRID --}}
    <section class="markets-section">
      @php
        // Sample data — asal project mein controller se $markets bhejna:
        // return view('markets', ['markets' => Market::with('farmers')->paginate(9)]);
        $sampleMarkets = [
          ['slug' => 'market-market',  'img' => 'market-1.jpg', 'name' => 'Market Market',  'location' => 'Nectilmenton, CA', 'distance' => '337 km', 'days' => 'Monday, Friday', 'hours' => '10am – 2pm',  'farmers' => 25, 'tags' => ['Vegetables', 'Fruits']],
          ['slug' => 'herbs-market',   'img' => 'market-2.jpg', 'name' => 'Herbs Market',   'location' => 'Parx Banton, VK',  'distance' => '351 km', 'days' => 'Sunday',       'hours' => '12pm – 2pm',  'farmers' => 25, 'tags' => ['Herbs & Spices']],
          ['slug' => 'law-tears',      'img' => 'market-3.jpg', 'name' => 'Law Tears',      'location' => 'Law Tears, CA',    'distance' => '331 km', 'days' => 'Sep 15',       'hours' => '5pm – 8pm',   'farmers' => 25, 'tags' => ['Dairy', 'Organic']],
          ['slug' => 'west-nork',      'img' => 'market-4.jpg', 'name' => 'West Nork',      'location' => 'West Nork, UK',    'distance' => null,     'days' => 'Mon, July',    'hours' => '10am – 2pm',  'farmers' => 3,  'tags' => ['Vegetables']],
          ['slug' => 'west-morouta',   'img' => 'market-5.jpg', 'name' => 'West Morouta',   'location' => 'West Morouta, UK', 'distance' => null,     'days' => 'Mon, July',    'hours' => '10am – 2pm',  'farmers' => 6,  'tags' => ['Fruits']],
          ['slug' => 'west-pexra',     'img' => 'market-6.jpg', 'name' => 'West Pexra',     'location' => 'West Pexra, UA',   'distance' => null,     'days' => 'Mon, Jerry',   'hours' => '10am – 2pm',  'farmers' => 3,  'tags' => ['Baked Goods']],
        ];
      @endphp

      <div class="markets-grid">
        @foreach ($sampleMarkets as $market)
          <div class="market-card">
            <div class="thumb">
              <img src="{{ asset('images/markets/' . $market['img']) }}" alt="{{ $market['name'] }}">
            </div>
            <div class="body">
              <div class="top-row">
                <p class="name">{{ $market['name'] }}</p>
                @if ($market['distance'])
                  <span class="distance">{{ $market['distance'] }}</span>
                @endif
              </div>
              <p class="location">{{ $market['location'] }}</p>

              <div class="meta">
                <div>
                  <span>Operating days</span>
                  <strong>{{ $market['days'] }}</strong>
                </div>
                <div>
                  <span>Opening hours</span>
                  <strong>{{ $market['hours'] }}</strong>
                </div>
              </div>

              <p class="location" style="margin-bottom:8px;">{{ $market['farmers'] }} farmers</p>

              <div class="tags">
                @foreach ($market['tags'] as $tag)
                  <span class="tag">{{ $tag }}</span>
                @endforeach
              </div>

              <a href="#" class="btn-view-market">View Market</a>
            </div>
          </div>
        @endforeach
      </div>

      {{-- FEATURED MARKET --}}
      <div class="featured-market">
        <div class="thumb">
          <img src="{{ asset('images/markets/featured-market.jpg') }}" alt="Featured market">
        </div>
        <div class="body">
          <p class="name">Featured Market</p>
          <p class="location">Larentown, UA</p>
          <p class="desc">
            Discover local farmers, explore fresh produce, and pre-order for
            convenient market pickup.
          </p>
          <div class="stats">
            <div>
              <strong>39</strong>
              <span>Farmers</span>
            </div>
            <div>
              <strong>Daily</strong>
              <span>Products restocked</span>
            </div>
            <div>
              <strong>Mon, Fri</strong>
              <span>Operating days</span>
            </div>
            <div>
              <strong>10am – 3pm</strong>
              <span>Opening hours</span>
            </div>
          </div>
          <a href="#" class="btn-explore">Explore Farmers</a>
        </div>
      </div>
    </section>
  </div>

  {{-- FOOTER (same as Products page) --}}
  <footer class="site-footer">
    <div class="footer-inner">
      <span class="footer-brand">MarketLink</span>

      <div class="footer-links">
        <a href="#">About</a>
        <a href="{{ route('markets') }}">Markets</a>
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

</body>
</html> 