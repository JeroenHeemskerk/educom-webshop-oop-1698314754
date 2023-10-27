<?php
    include 'user_service.php';
    include 'file_repository.php';
    include 'validations.php';
    include 'session_manager.php';
    include 'products_service.php';
    include 'forms.php';
    include 'tables.php';

    session_start();

    $page = getRequestedPage();
    $data = processRequest($page);
    showResponsePage($data);

    function getRequestedPage() {
    
        //Indien sprake is van een POST-request wordt onderzocht welk formulier is opgegeven
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            return getPostVar('page', 'home');
    
        //Indien sprake is van een GET-request wordt bepaald welke pagina weergegeven moet worden
        } else if ($_SERVER["REQUEST_METHOD"] == "GET"){        
            return getUrlVar('page', 'home');            
        }
    }

    function getVar($key, $default='') {

        //Combineert getPostVar en getUrlVar zodat één aanroep voldoende is
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            return getPostVar($key);
        } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
            return getUrlVar($key);
        }
    }
    
    function getPostVar($key, $default=''){
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }
	
	function getUrlVar($key, $default='') { 
		return isset($_GET[$key]) ? $_GET[$key] : $default; 
	} 

    function processRequest($page) {
    
        switch ($page) {        
            case "login":            
                $data = validateLogin();
                if ($data['valid']) {                
                    loginUser($data['name'], $data['email']);
                    $page = "home";
                }
                break;        
            case "logout":        
                logoutUser();
                $page = "home";
                break;        
            case "contact":            
                $data = validateContact();
                break;
            case "register":
                $data = validateRegister();
                if ($data['valid']) {
                    registerNewAccount($data);
                    $page = "login";
                }
                break;
            case "webshop":
                $data = getWebshopProducts();
                createShoppingCart();
                $data += handleActions($data);           
                break;
            case "details":
                $data = getWebshopProductDetails(getVar('productId'));
                createShoppingCart();
                $data += handleActions($data);
                break;
            case "cart":
                $cart = getShoppingCart();
                $data = getCartLines($cart);
                $data = handleActions($data);
                break;
            case "orders":
                if (is_numeric(getVar('orderId'))) {
                    $data = getRowsByOrderId(getVar('orderId'));
                    $data += getOrdersAndSum();
                } else {
                    $data = getOrdersAndSum();
                }
                break;
        }
        
        //Aan $data wordt een array 'menu' toegevoegd met de standaard weer te geven items
        //Naar aanleiding van of de user ingelogd is wordt register en login of cart en logout toegevoegd
        $data['menu'] = array('home' => 'Home', 'about' => 'About', 'contact' => 'Contact', 'webshop' => 'Webshop');
        if (isUserLoggedIn()) {
            $data['menu']['cart'] = "Winkelwagen";
            $data['menu']['orders'] = "Bestellingen";
            $data['menu']['logout'] = "Logout " . getLoggedInUserName();
        } else {
            $data['menu']['register'] = "Register";
            $data['menu']['login'] = "Login";
        }
    
        $data['page'] = $page;
    
        return $data;
    }

    function handleActions($data) {

        //handleActions zorgt voor de afhandeling van bijvoorbeeld het toevoegen van een product aan de cart
        $action = getVar('userAction');
        switch ($action) {
            case "addToCart":
                $data += validateAddingProductToShoppingCart();
                if ($data['valid']){
                    addProductToShoppingCart($data['productId'], $data['quantity']);
                }
                return $data;
            case "completeOrder":
                $data += writeOrder($data);
                if ($data['valid']) {
                    emptyShoppingCart();
                    unset($data['cartLines']);
                }
                return $data;
            default:
                //errProductId en errQuantity worden niet geset bij de standaard weergave waardoor deze hier alsnog aangemaakt worden
                //ook wordt rekening gehouden met of de $data array al bestaat of niet
                if (isset($data)){
                    $data += array('errProductId' => "", 'errQuantity' => "");
                } else {
                    $data = array('errProductId' => "", 'errQuantity' => "");
                }
                return $data;
        }
    }

    function showResponsePage($data){
    
        showHTMLStart();
        showHeadSection($data);
        showBodySection($data);    
        showFooter();
        showHTMLEnd();
    }

    function showHeadSection ($data) {
    
        echo '<head>';
        echo '<title>';
		
		//getHeader haalt de header van de desbetreffende pagina en de header wordt vervolgens gebruikt om de title aan te maken
		$header = getHeader($data);
		if ($header == 'Home') {
			echo 'Nick zijn website';
		} else {
			echo $header;
		}		
        
        echo '</title>';
        echo '<link rel="stylesheet" href="./CSS/stylesheet.css">';
        echo '</head>';
    }

    function showBodySection($data) {
    
        echo '<body class="pagetext">';    
        showHeader($data);    
        showNavMenu($data);
        showError($data);        
        showContent($data);    
        echo '</body>';
    }

    function showContent($data) {
    
        switch ($data['page']) {
            case "home":
            case "logout":
                showHomeBody();
                break;
            case "about":
                showAboutBody();
                break;
            case "contact":
                showContactBody($data);
                break;
            case "register":
                showRegisterBody($data);
                break;
            case "login":
                showLoginBody($data);
                break;
            case "webshop":
                showWebshopBody($data);
                break;
            case "cart":
                showCartBody($data);
                break;
            case "orders":
                showOrdersBody($data);
                break;
            default:
                showProductBody($data);
                break;
        }
    }

    function showNavMenu($data) {
        
        //Het navigatiemenu wordt door middel van de eerder gedefinieerde items in processRequest opgemaakt
        echo '<ul class="nav">';        
        foreach($data['menu'] as $link => $label) {
            showMenuItem($link, $label);
        }
        echo '</ul><br>';    
    }

    function showMenuItem($page, $title) {
        echo '<li><a href="index.php?page=' . $page . '">' . $title . '</a></li>';
    }
    
    function showError($data) {
        
        if (isset($data['genericError']) && $data['genericError'] != ""){
        
            switch ($data['page']) {
                case "register":
                   echo '<br><h2 class="error">' . $data['genericError'] . '</h2>';
                    break;
                case "login":
                    echo '<br><h2 class="error">' . $data['genericError'] . '</h2>';
                    break;
                case "webshop":
                    echo '<br><h2 class="error">' . $data['genericError'] . '</h2>';
                    break;
                case "details":
                    echo '<br><h2 class="error">' . $data['genericError'] . '</h2>';
                    break;
                case "cart":
                    echo '<br><h2 class="error">' . $data['genericError'] . '</h2>';
                    break;
                case "orders":
                    echo '<br><h2 class="error">' . $data['genericError'] . '</h2>';
                    break;
                default:
                break;
            }
        }
    }
    
    function logError($msg) {
        //echo 'Logging to errorlog: ' . $msg;
    }
	
	function showHeader($data) {
		echo '<h1>' . getHeader($data) . '</h1>';
	}

    function getHeader($data) {
        
        //Returnt de header vanuit de desbetreffende pagina en include daarmee ook de respectievelijke php file
        switch ($data['page']) {
            case "home":
            case "logout":
                require_once 'home.php';
                return getHomeHeader();
            case "about":
                require_once 'about.php';
                return getAboutHeader();
            case "contact":
                require_once 'contact.php';
                return getContactHeader($data);
            case "register":
                require_once 'register.php';
                return getRegisterHeader();
            case "login":
                require_once 'login.php';
                return getLoginHeader();
            case "webshop":
                require_once 'webshop.php';
                return getWebshopHeader();
            case "details":
                require_once 'product.php';
                return getProductHeader();
            case "cart":
                require_once 'cart.php';
                return getCartHeader();
            case "orders":
                require_once 'orders.php';
                return getOrdersHeader();
            default:
                require_once 'home.php';
                return getHomeHeader();
        }
    }

    function showFooter() {
    
        echo '<footer><p>&copy 2023<br>Nick Koole</p></footer>';
    }

    function showHTMLStart() {
    
        echo "<html>";
    }

    function showHTMLEnd() {
    
        echo "</html>";
    }
?>



