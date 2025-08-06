import {
  Box,
  Image,
  Text,
  Button,
  Badge,
  HStack,
  VStack,
  Flex,
  IconButton,
  useColorModeValue,
} from "@chakra-ui/react";
import { CloseIcon } from "@chakra-ui/icons";

export default function WishlistCard({ product, onAddToCart, onCheckout, onRemove }) {
  const imageUrl = `http://localhost:8080/uploads/${product.image}`;
  const price = new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
  }).format(product.price);

  return (
    <Box
      borderWidth="1px"
      borderRadius="xl"
      overflow="hidden"
      bg={useColorModeValue("white", "gray.800")}
      boxShadow="sm"
      p={4}
      _hover={{ boxShadow: "md", transform: "scale(1.01)" }}
      transition="all 0.2s ease"
    >
      <Flex gap={4} align="center">
        {/* Gambar Produk */}
        <Image
          src={imageUrl}
          alt={product.name}
          fallbackSrc="https://placehold.co/100x100?text=No+Image"
          objectFit="cover"
          boxSize="100px"
          borderRadius="md"
        />

        {/* Konten */}
        <VStack align="start" spacing={2} flex="1">
          <HStack justify="space-between" w="full">
            <Text fontWeight="semibold" fontSize="md" noOfLines={2}>
              {product.name}
            </Text>
            <IconButton
              icon={<CloseIcon />}
              size="sm"
              colorScheme="red"
              variant="ghost"
              aria-label="Hapus dari wishlist"
              onClick={() => onRemove(product.id)}
            />
          </HStack>

          <Text color="pink.500" fontWeight="bold" fontSize="sm">
            {price}
          </Text>

          {product.avg_rating && (
            <Badge colorScheme="pink" fontSize="0.65em">
              ⭐ {product.avg_rating} / 5
            </Badge>
          )}

          <HStack spacing={2} pt={2}>
            <Button
              size="sm"
              colorScheme="pink"
              variant="outline"
              onClick={() => onAddToCart(product)}
            >
              + Keranjang
            </Button>
            <Button
              size="sm"
              colorScheme="pink"
              onClick={() => onCheckout(product)}
            >
              Beli
            </Button>
          </HStack>
        </VStack>
      </Flex>
    </Box>
  );
}
