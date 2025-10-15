<nav class="bottom-nav">
    <div class="container bottom-nav-container">
        <div class="d-flex justify-content-center align-items-center">
            <x-navigation.nav-link route="#" icon-active="fa-solid fa-compass" icon-inactive="fa-regular fa-compass" label="Explore"/>
            <x-navigation.nav-link :route="route('pages.home.index')" icon-active="fa-solid fa-house" icon-inactive="fa-solid fa-house" label="Home"/>
            <x-navigation.nav-link :route="route('cart.index')" icon-active="fa-solid fa-cart-shopping" icon-inactive="fa-solid fa-cart-shopping" label="Cart"/>
            <x-navigation.nav-link route="#" icon-active="fa-solid fa-heart" icon-inactive="fa-regular fa-heart" label="Favorites"/>
            <x-navigation.nav-link route="#" icon-active="fa-solid fa-bell" icon-inactive="fa-regular fa-bell" label="Notifications"/>
        </div>
    </div>
</nav>