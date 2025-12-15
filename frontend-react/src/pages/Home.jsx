import {
  Box,
  Heading,
  Text,
  Button,
  Image,
  SimpleGrid,
  VStack,
  LinkBox,
  LinkOverlay,
  useColorModeValue,
} from '@chakra-ui/react';
import { Link as RouterLink } from 'react-router-dom';
import { useEffect, useState } from 'react';
import { fetchTopRatedProducts } from '../services/productService';
import { motion, AnimatePresence } from 'framer-motion';

const MotionBox = motion(Box);
const MotionImage = motion(Image);

const heroSlides = [
  {
    image: 'https://images.unsplash.com/photo-1521334884684-d80222895322?ixlib=rb-4.0.3&auto=format&fit=crop&w=1400&q=80',
    title: 'Selamat Datang di Lunaya Store',
    description: 'Temukan fashion favoritmu dengan gaya kekinian!',
  },
  {
    image: 'https://images.unsplash.com/photo-1618354691436-4fda278f3264?ixlib=rb-4.0.3&auto=format&fit=crop&w=1400&q=80',
    title: 'Promo Spesial Minggu Ini',
    description: 'Dapatkan diskon menarik untuk produk pilihan.',
  },
  {
    image: 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1400&q=80',
    title: 'Koleksi Terbaru Telah Tiba',
    description: 'Gaya baru, rasa baru. Yuk belanja sekarang!',
  },
];

function Home() {
  const [products, setProducts] = useState([]);
  const [error, setError] = useState('');
  const [index, setIndex] = useState(0);

  const cardBg = useColorModeValue('white', 'gray.800');
  const sectionBg = useColorModeValue('gray.50', 'gray.900');

  useEffect(() => {
    fetchTopRatedProducts()
      .then((data) => setProducts(data.slice(0, 4))) // tampilkan hanya 4 produk rating tertinggi
      .catch(() => setError('Gagal memuat produk.'));
  }, []);

  useEffect(() => {
    const interval = setInterval(() => {
      setIndex((prev) => (prev + 1) % heroSlides.length);
    }, 5000);
    return () => clearInterval(interval);
  }, []);

  return (
    <Box>
      {/* Hero Section */}
      <Box position="relative" h="500px" overflow="hidden" mb={12}>
        <AnimatePresence mode="sync">
          {heroSlides.map((slide, i) =>
            i === index ? (
              <MotionBox
                key={i}
                position="absolute"
                top={0}
                left={0}
                w="full"
                h="full"
                zIndex={1}
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                exit={{ opacity: 0 }}
                transition={{ duration: 1.5 }}
              >
                <MotionImage
                  src={slide.image}
                  alt={slide.title}
                  objectFit="cover"
                  w="full"
                  h="full"
                  position="absolute"
                  top={0}
                  left={0}
                  zIndex={-1}
                />
                <Box
                  position="absolute"
                  top={0}
                  left={0}
                  w="full"
                  h="full"
                  bg="rgba(0, 0, 0, 0.5)"
                />
                <Box
                  position="relative"
                  zIndex={2}
                  display="flex"
                  flexDir="column"
                  alignItems="center"
                  justifyContent="center"
                  h="100%"
                  px={4}
                  textAlign="center"
                  color="white"
                >
                  <MotionBox
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: 0.4 }}
                  >
                    <Heading fontSize={{ base: '3xl', md: '5xl' }} mb={4}>
                      {slide.title}
                    </Heading>
                    <Text fontSize="xl" mb={6}>
                      {slide.description}
                    </Text>
                    <Button
                      as={RouterLink}
                      to="/products"
                      colorScheme="pink"
                      size="lg"
                      shadow="xl"
                    >
                      Lihat Produk
                    </Button>
                  </MotionBox>
                </Box>
              </MotionBox>
            ) : null
          )}
        </AnimatePresence>
      </Box>

      {/* Produk Unggulan */}
      <Box py={16} px={{ base: 4, md: 10 }} bg={sectionBg}>
        <Heading size="xl" mb={10} textAlign="center" color="pink.600">
          Produk Unggulan
        </Heading>

        {error && (
          <Text color="red.500" textAlign="center" mb={8}>
            {error}
          </Text>
        )}

        <SimpleGrid columns={{ base: 1, sm: 2, md: 4 }} spacing={8}>
          {products.map((product) => (
            <MotionBox
              as={LinkBox}
              key={product.id}
              borderWidth="1px"
              borderRadius="2xl"
              bg={cardBg}
              boxShadow="lg"
              whileHover={{ y: -4 }}
              transition={{ duration: 0.2 }}
              overflow="hidden"
            >
              <Image
                src={
                  product.image
                    ? `http://localhost:8080/uploads/${product.image}`
                    : `https://via.placeholder.com/400x300?text=${encodeURIComponent(product.name)}`
                }
                alt={product.name}
                objectFit="cover"
                w="100%"
                h="200px"
              />
              <Box p={4}>
                <VStack align="start" spacing={2}>
                  <LinkOverlay as={RouterLink} to={`/product/${product.id}`}>
                    <Text fontWeight="semibold" fontSize="lg" noOfLines={1}>
                      {product.name}
                    </Text>
                  </LinkOverlay>
                  <Text fontSize="sm" color="gray.500" noOfLines={2}>
                    {product.description}
                  </Text>
                  <Text fontSize="lg" fontWeight="bold" color="pink.500" mt={2}>
                    Rp {Number(product.price).toLocaleString()}
                  </Text>
                </VStack>
              </Box>
            </MotionBox>
          ))}
        </SimpleGrid>

        <Box textAlign="center" mt={12}>
          <Button
            as={RouterLink}
            to="/products"
            colorScheme="pink"
            size="md"
            px={8}
          >
            Jelajahi Semua Produk
          </Button>
        </Box>
      </Box>
    </Box>
  );
}

export default Home;
