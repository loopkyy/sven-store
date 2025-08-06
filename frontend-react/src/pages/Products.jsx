import {
  Box,
  Text,
  Spinner,
  Center,
  Input,
  InputGroup,
  InputRightElement,
  IconButton,
  SimpleGrid,
  Button,
  Wrap,
  WrapItem,
} from '@chakra-ui/react';
import { useEffect, useState } from 'react';
import { SearchIcon } from '@chakra-ui/icons';
import ProductCard from '../components/ProductCard';

export default function Products() {
  const [products, setProducts] = useState([]);
  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(true);
  const [query, setQuery] = useState('');
  const [currentPage, setCurrentPage] = useState(1);
  const [selectedCategory, setSelectedCategory] = useState(null);
  const productsPerPage = 12;

  // Fetch products
  useEffect(() => {
    fetch('http://localhost:8080/api/products')
      .then((res) => res.json())
      .then((data) => {
        setProducts(data.products || []);
        setLoading(false);
      })
      .catch((err) => {
        console.error('Error fetching products:', err);
        setLoading(false);
      });
  }, []);

  // Fetch categories
  useEffect(() => {
    fetch('http://localhost:8080/api/categories')
      .then((res) => res.json())
      .then((data) => {
        console.log('CATEGORIES API RESULT:', data);
        setCategories(data.data || []); // ✅ Perbaikan di sini
      })
      .catch((err) => {
        console.error('Error fetching categories:', err);
      });
  }, []);

  // Reset halaman saat query/kategori berubah
  useEffect(() => {
    setCurrentPage(1);
  }, [query, selectedCategory]);

  // Filter produk
  const filtered = products.filter((p) => {
    const matchName = p.name.toLowerCase().includes(query.toLowerCase());
    const matchCategory = selectedCategory ? p.category_id === selectedCategory : true;
    return matchName && matchCategory;
  });

  // Pagination
  const indexOfLast = currentPage * productsPerPage;
  const indexOfFirst = indexOfLast - productsPerPage;
  const currentProducts = filtered.slice(indexOfFirst, indexOfLast);
  const totalPages = Math.ceil(filtered.length / productsPerPage);

  return (
    <Box px={{ base: 4, md: 10 }} py={10}>
      <Text fontSize="3xl" fontWeight="bold" mb={2} textAlign="center" color="pink.500">
        Semua Produk
      </Text>

      <Text fontSize="md" color="gray.500" textAlign="center" mb={6}>
        Temukan produk terbaik untuk gayamu!
      </Text>

      {/* Search */}
      <Center mb={6}>
        <InputGroup maxW="400px">
          <Input
            placeholder="Cari produk..."
            value={query}
            onChange={(e) => setQuery(e.target.value)}
            bg="white"
          />
          <InputRightElement>
            <IconButton icon={<SearchIcon />} size="sm" aria-label="Search" />
          </InputRightElement>
        </InputGroup>
      </Center>

      {/* Filter kategori */}
      <Wrap justify="center" mb={8}>
        <WrapItem>
          <Button
            colorScheme={!selectedCategory ? 'pink' : 'gray'}
            variant={!selectedCategory ? 'solid' : 'outline'}
            onClick={() => setSelectedCategory(null)}
            size="sm"
          >
            Semua
          </Button>
        </WrapItem>
        {categories.map((cat) => (
          <WrapItem key={cat.id}>
            <Button
              colorScheme={selectedCategory === cat.id ? 'pink' : 'gray'}
              variant={selectedCategory === cat.id ? 'solid' : 'outline'}
              onClick={() => setSelectedCategory(cat.id)}
              size="sm"
            >
              {cat.name}
            </Button>
          </WrapItem>
        ))}
      </Wrap>

      {}
      {loading ? (
        <Center py={10}>
          <Spinner size="xl" color="pink.500" />
        </Center>
      ) : currentProducts.length > 0 ? (
        <>
          <SimpleGrid columns={{ base: 2, md: 3, lg: 4 }} spacing={6}>
            {currentProducts.map((product) => (
              <ProductCard key={product.id} product={product} />
            ))}
          </SimpleGrid>

          {}
          <Center mt={8} gap={3}>
            <IconButton
              icon={<Text>{'<'}</Text>}
              aria-label="Previous"
              onClick={() => setCurrentPage((p) => Math.max(p - 1, 1))}
              isDisabled={currentPage === 1}
            />
            <Text>
              Halaman {currentPage} dari {totalPages}
            </Text>
            <IconButton
              icon={<Text>{'>'}</Text>}
              aria-label="Next"
              onClick={() => setCurrentPage((p) => Math.min(p + 1, totalPages))}
              isDisabled={currentPage === totalPages}
            />
          </Center>
        </>
      ) : (
        <Center py={10}>
          <Text color="gray.500">Tidak ada produk ditemukan.</Text>
        </Center>
      )}
    </Box>
  );
}
