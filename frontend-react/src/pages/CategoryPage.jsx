import {
  Box,
  Text,
  Heading,
  SimpleGrid,
  Spinner,
  Center,
  IconButton,
  Button,
  VStack,
  useColorModeValue,
} from '@chakra-ui/react';
import { ArrowBackIcon } from '@chakra-ui/icons';
import { useParams, useNavigate } from 'react-router-dom';
import { useEffect, useState } from 'react';
import ProductCard from '../components/ProductCard';
import { motion } from 'framer-motion';

export default function CategoryPage() {
  const { slug } = useParams();
  const [category, setCategory] = useState(null);
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();
  const bgGradient = useColorModeValue('linear(to-r, pink.400, pink.300)', 'gray.700');

  useEffect(() => {
    setLoading(true);
    Promise.all([
      fetch(`http://localhost:8080/api/categories/slug/${slug}`).then((res) => res.json()),
      fetch(`http://localhost:8080/api/products?category_slug=${slug}`).then((res) => res.json()),
    ])
      .then(([catRes, prodRes]) => {
        setCategory(catRes?.data ?? null);
        setProducts(prodRes?.products ?? []);
        setLoading(false);
      })
      .catch((err) => {
        console.error('Error fetching category/products:', err);
        setLoading(false);
      });
  }, [slug]);

  if (loading) {
    return (
      <Center minH="60vh">
        <Spinner size="xl" color="pink.500" />
      </Center>
    );
  }

  if (!category) {
    return (
      <Center py={10}>
        <VStack spacing={4}>
          <Text fontSize="xl" color="gray.500">
            Kategori tidak ditemukan.
          </Text>
          <Button onClick={() => navigate('/products')} colorScheme="pink">
            Kembali ke Produk
          </Button>
        </VStack>
      </Center>
    );
  }

  return (
    <Box px={{ base: 4, md: 10 }} py={10}>
      <Box
        bgGradient={bgGradient}
        color="white"
        p={8}
        borderRadius="2xl"
        mb={10}
        textAlign="center"
        position="relative"
        as={motion.div}
        initial={{ opacity: 0, y: -20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5 }}
      >
        <IconButton
          icon={<ArrowBackIcon />}
          position="absolute"
          top={4}
          left={4}
          onClick={() => navigate('/products')}
          colorScheme="whiteAlpha"
          variant="ghost"
          aria-label="Kembali"
        />
        <Heading fontSize={{ base: '2xl', md: '3xl' }} mb={2}>
          {category.name}
        </Heading>
        {category.description && (
          <Text fontSize="md" opacity={0.9}>
            {category.description}
          </Text>
        )}
      </Box>

      {products.length > 0 ? (
        <SimpleGrid columns={{ base: 2, md: 3, lg: 4 }} spacing={6}>
          {products.map((product) => (
            <motion.div
              key={product.id}
              initial={{ opacity: 0, scale: 0.95 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ duration: 0.3 }}
            >
              <ProductCard product={product} />
            </motion.div>
          ))}
        </SimpleGrid>
      ) : (
        <Center py={10}>
          <Text color="gray.500">Belum ada produk di kategori ini.</Text>
        </Center>
      )}
    </Box>
  );
}
