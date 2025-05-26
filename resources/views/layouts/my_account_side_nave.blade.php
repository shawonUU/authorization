<nav class="woocommerce-MyAccount-navigation">
    <ul>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard ">
        <a href="">ড্যাশবোর্ড</a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders ">
            <a href="">অর্ডার সমূহ</a>
        </li>
        <li style="display:none;" class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address">
        <a href="javascript:void(0)">ঠিকানা</a>
        </li>
        <li style="display:none;" class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--woo-wallet">
        <a href="javascript:void(0)">ওয়ালেট</a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account ">
        <a href="">প্রোফাইল</a>
        </li>
        <li style="display:none;" class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--wishlist">
        <a href="javascript:void(0)">উইশ লিস্ট</a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
            <form id="logoutId" action="" method="post">
                @csrf
                <a onclick="document.getElementById('logoutId').submit()" href="javascript:void(0)">লগআউট</a>
            </form>
        </li>
    </ul>
</nav>