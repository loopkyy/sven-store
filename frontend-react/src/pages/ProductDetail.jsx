import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';
import {
  Box,
  Heading,
  Image,
  Text,
  Stack,
  IconButton,
  SimpleGrid,
  Badge,
  useToast,
  HStack,
  Divider,
  Button,
  VStack,
} from '@chakra-ui/react';
import {
  FaShoppingCart,
  FaHeart,
  FaMoneyBillWave,
  FaPlus,
  FaMinus,
} from 'react-icons/fa';
import ProductCard from '../components/ProductCard';

export default function ProductDetail() {
  const { slug } = useParams();
  const [product, setProduct] = useState(null);
  const [related, setRelated] = useState([]);
  const [wishlist, setWishlist] = useState([]);
  const [loading, setLoading] = useState(true);
  const [quantity, setQuantity] = useState(1);
  const toast = useToast();

  useEffect(() => {
    const fetchData = async () => {
      try {
        const res = await axios.get(`http://localhost:8080/api/products/slug/${slug}`);
        setProduct(res.data.product);
        setRelated(res.data.relatedProducts);
      } catch (err) {
        console.error('Gagal ambil produk:', err);
      }

      await fetchWishlist();
      setLoading(false);
    };

    fetchData();
  }, [slug]);

  const fetchWishlist = async () => {
    try {
      const res = await axios.get(`http://localhost:8080/api/wishlist`, {
        withCredentials: true,
      });
      setWishlist(res.data.wishlist || []);
    } catch (err) {
      console.error('Gagal ambil wishlist:', err);
    }
  };

  const handleAddToCart = async () => {
    try {
      const res = await axios.post(
        'http://localhost:8080/api/cart/add',
        { product_id: product.id, qty: quantity },
        { withCredentials: true }
      );

      toast({
        title: res.data.status ? 'Berhasil' : 'Gagal',
        description: res.data.message || 'Gagal tambah ke keranjang.',
        status: res.data.status ? 'success' : 'error',
        duration: 2000,
        isClosable: true,
      });
    } catch (err) {
      toast({
        title: 'Gagal',
        description: 'Terjadi kesalahan saat menambahkan ke keranjang.',
        status: 'error',
        duration: 2000,
        isClosable: true,
      });
    }
  };

  const handleWishlist = async () => {
    if (!product) return;

    const isWishlisted = wishlist.some((item) => item.id === product.id);
    const url = isWishlisted
      ? 'http://localhost:8080/api/wishlist/remove'
      : 'http://localhost:8080/api/wishlist/add';

    try {
      const res = await axios.post(
        url,
        { product_id: product.id },
        { withCredentials: true }
      );

      if (res.data.status) {
        toast({
          title: isWishlisted ? 'Dihapus' : 'Ditambahkan',
          description: res.data.message || 'Wishlist diperbarui.',
          status: isWishlisted ? 'warning' : 'info',
          duration: 2000,
          isClosable: true,
        });

        await fetchWishlist();
      }
    } catch (err) {
      toast({
        title: 'Gagal',
        description: 'Terjadi kesalahan saat memperbarui wishlist.',
        status: 'error',
        duration: 2000,
        isClosable: true,
      });
    }
  };

  const handleCheckout = () => {
    toast({
      title: 'Menuju Checkout',
      description: 'Silakan lanjut ke pembayaran.',
      status: 'warning',
      duration: 2000,
      isClosable: true,
    });
  };

  const increaseQty = () => setQuantity((prev) => prev + 1);
  const decreaseQty = () => setQuantity((prev) => (prev > 1 ? prev - 1 : 1));

  if (loading) return <Text mt={10}>Loading...</Text>;
  if (!product) return <Text>Produk tidak ditemukan.</Text>;

  const isWishlisted = wishlist.some((item) => item.id === product.id);

  return (
    <Box px={{ base: 4, md: 20 }} py={10}>
      <SimpleGrid columns={{ base: 1, md: 2 }} spacing={10}>
        <Image
          src={product.image_url}
          alt={product.name}
          borderRadius="xl"
          boxShadow="lg"
          objectFit="cover"
          w="100%"
          h="auto"
        />
        <Stack spacing={5}>
          <Heading fontSize="3xl">{product.name}</Heading>
          <Badge colorScheme="purple" w="fit-content" px={3} py={1} borderRadius="md">
            {product.category_name}
          </Badge>
          <Text fontSize="2xl" fontWeight="bold" color="pink.500">
            Rp{Number(product.price).toLocaleString()}
          </Text>
          <Text fontSize="md" color="gray.600">
            {product.description}
          </Text>

          <VStack align="start" spacing={3} pt={4}>
            <HStack>
              <Text>Jumlah:</Text>
              <HStack spacing={2} border="1px solid #ccc" px={2} py={1} borderRadius="md">
                <IconButton
                  icon={<FaMinus />}
                  aria-label="Kurangi"
                  onClick={decreaseQty}
                  size="sm"
                  variant="ghost"
                />
                <Text w="20px" textAlign="center">
                  {quantity}
                </Text>
                <IconButton
                  icon={<FaPlus />}
                  aria-label="Tambah"
                  onClick={increaseQty}
                  size="sm"
                  variant="ghost"
                />
              </HStack>
            </HStack>

            <HStack spacing={3}>
              <Button
                leftIcon={<FaShoppingCart />}
                onClick={handleAddToCart}
                colorScheme="pink"
                size="sm"
                borderRadius="md"
              >
                Keranjang
              </Button>
              <Button
                leftIcon={<FaHeart />}
                onClick={handleWishlist}
                colorScheme={isWishlisted ? 'red' : 'gray'}
                variant="outline"
                size="sm"
                borderRadius="md"
              >
                {isWishlisted ? 'Hapus Wishlist' : 'Wishlist'}
              </Button>
              <Button
                leftIcon={<FaMoneyBillWave />}
                onClick={handleCheckout}
                colorScheme="green"
                size="sm"
                borderRadius="md"
              >
                Checkout
              </Button>
            </HStack>
          </VStack>
        </Stack>
      </SimpleGrid>

      <Divider my={12} />

      <Box mt={6}>
        <Heading size="lg" mb={6}>
          Produk Terkait
        </Heading>
        {related.length === 0 ? (
          <Text>Tidak ada produk terkait.</Text>
        ) : (
          <SimpleGrid columns={{ base: 2, md: 4 }} spacing={6}>
            {related.map((item) => (
              <ProductCard key={item.id} product={item} />
            ))}
          </SimpleGrid>
        )}
      </Box>
    </Box>
  );
}
