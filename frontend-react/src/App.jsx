import { Routes, Route } from 'react-router-dom';
import Home from './pages/Home';
import ProductList from './pages/Products';
import ProductDetail from './pages/ProductDetail';
import Navbar from './components/Navbar';
import Footer from './components/Footer';
import CartPage from './pages/CartPage';
import WishlistPage from './pages/WishlistPage';
import CategoryPage from './pages/CategoryPage';
import AuthPage from './pages/AuthPage';
import ProfilePage from './pages/ProfilePage';
import CheckoutPage from './pages/CheckoutPage';


function App() {
  return (
    <>
      <Navbar />
      <Routes>
  <Route path="/" element={<Home />} />
        <Route path="/products" element={<ProductList />} />
        <Route path="/product/:slug" element={<ProductDetail />} />
        <Route path="/cart" element={<CartPage />} />
        <Route path="/wishlist" element={<WishlistPage />} />
       <Route path="/category/:slug" element={<CategoryPage />} />
       <Route path="/auth" element={<AuthPage />} />
       <Route path="/profile" element={<ProfilePage />} />
       <Route path="/checkout" element={<CheckoutPage />} />



      </Routes>
      <Footer />
    </>
  );
}

export default App;
