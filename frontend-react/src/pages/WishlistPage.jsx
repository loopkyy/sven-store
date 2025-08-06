import {
  Box,
  Heading,
  Text,
  Spinner,
  Center,
  VStack,
  Icon,
  useToast,
  Stack,
  Button,
  HStack,
} from "@chakra-ui/react";
import { useEffect, useState } from "react";
import axios from "axios";
import { FaHeartBroken } from "react-icons/fa";
import WishlistCard from "../components/WishlistCard";

function WishlistPage() {
  const [wishlist, setWishlist] = useState([]);
  const [loading, setLoading] = useState(true);
  const toast = useToast();

  const fetchWishlist = async () => {
    try {
      const res = await axios.get("http://localhost:8080/api/wishlist", {
        withCredentials: true,
      });
      console.log("WISHLIST API RESPONSE:", res.data);
      if (res.data && Array.isArray(res.data.wishlist)) {
        setWishlist(res.data.wishlist);
      } else {
        setWishlist([]);
      }
    } catch (err) {
      console.error("Gagal memuat wishlist:", err);
      setWishlist([]);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchWishlist();
  }, []);

  const handleAddToCart = async (product) => {
    try {
      await axios.post(
        "http://localhost:8080/api/cart/add",
        {
          product_id: product.id,
          qty: 1,
        },
        { withCredentials: true }
      );
      toast({
        title: "Berhasil",
        description: `${product.name} ditambahkan ke keranjang.`,
        status: "success",
        duration: 2000,
        isClosable: true,
      });
    } catch (err) {
      toast({
        title: "Gagal",
        description: "Gagal menambahkan ke keranjang.",
        status: "error",
        duration: 2000,
        isClosable: true,
      });
    }
  };

  const handleCheckout = (product) => {
    localStorage.setItem("checkout_product", JSON.stringify(product));
    window.location.href = "/checkout";
  };

  const handleRemoveWishlist = async (productId) => {
    try {
      await axios.post(
        `http://localhost:8080/api/wishlist/remove`,
        { product_id: productId },
        { withCredentials: true }
      );
      setWishlist((prev) => prev.filter((item) => item.id !== productId));
      toast({
        title: "Dihapus",
        description: "Produk dihapus dari wishlist.",
        status: "info",
        duration: 2000,
        isClosable: true,
      });
    } catch (err) {
      console.error("Gagal menghapus item:", err);
    }
  };

  const handleClearWishlist = async () => {
    try {
      await axios.post(
        "http://localhost:8080/api/wishlist/clear",
        {},
        { withCredentials: true }
      );
      setWishlist([]);
      toast({
        title: "Wishlist dikosongkan",
        description: "Semua item wishlist telah dihapus.",
        status: "info",
        duration: 2000,
        isClosable: true,
      });
    } catch (err) {
      console.error("Gagal menghapus semua wishlist:", err);
    }
  };

  return (
    <Box p={{ base: 4, md: 8 }}>
      <HStack justify="space-between" mb={6}>
        <Heading size="lg">Wishlist Saya</Heading>
        {wishlist.length > 0 && (
          <Button
            size="sm"
            colorScheme="red"
            variant="outline"
            onClick={handleClearWishlist}
          >
            Hapus Semua
          </Button>
        )}
      </HStack>

      {loading ? (
        <Center>
          <Spinner size="lg" color="pink.400" />
        </Center>
      ) : wishlist.length === 0 ? (
        <Center>
          <VStack spacing={4}>
            <Icon as={FaHeartBroken} boxSize={10} color="gray.400" />
            <Text fontSize="lg" color="gray.500">
              Belum ada produk di wishlist kamu.
            </Text>
          </VStack>
        </Center>
      ) : (
        <Stack spacing={6}>
          {wishlist.map((product) => (
            <WishlistCard
              key={product.id}
              product={product}
              onAddToCart={handleAddToCart}
              onCheckout={handleCheckout}
              onRemove={handleRemoveWishlist}
            />
          ))}
        </Stack>
      )}
    </Box>
  );
}

export default WishlistPage;
