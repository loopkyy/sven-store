// src/services/productService.js

export async function fetchProducts() {
  try {
    const response = await fetch('http://localhost:8080/api/products');
    const result = await response.json();
    return result.products || [];
  } catch (error) {
    console.error('Error fetching products:', error);
    return [];
  }
}

export async function fetchTopRatedProducts() {
  try {
    const response = await fetch('http://localhost:8080/api/products/top-rated');
    const result = await response.json();
    console.log("Hasil Produk Top Rated:", result);
    return result.data; // GANTI DARI result.products KE result.data
  } catch (error) {
    console.error('Error fetching top-rated products:', error);
    return [];
  }
}
