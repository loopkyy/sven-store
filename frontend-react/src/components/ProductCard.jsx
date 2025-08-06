import {
  Box,
  Image,
  Text,
  Stack,
  Button,
  Badge,
  useColorModeValue,
} from "@chakra-ui/react";
import { Link as RouterLink } from "react-router-dom";

export default function ProductCard({ product }) {
  const imageUrl = `http://localhost:8080/uploads/${product.image}`;
  const price = new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
  }).format(product.price);

  return (
    <Box
      borderWidth="1px"
      borderRadius="2xl"
      overflow="hidden"
      bg={useColorModeValue("white", "gray.800")}
      boxShadow="md"
      _hover={{ boxShadow: "xl", transform: "scale(1.02)" }}
      transition="all 0.2s ease"
    >
      <Image
        src={imageUrl}
        fallbackSrc="https://via.placeholder.com/300x250?text=No+Image"
        alt={product.name}
        objectFit="cover"
        w="100%"
        h="250px"
      />

      <Box p={4}>
        <Stack spacing={2}>
          <Text fontWeight="bold" fontSize="md" isTruncated>
            {product.name}
          </Text>
          <Text color="pink.500" fontWeight="semibold">
            {price}
          </Text>

          {product.avg_rating && (
            <Badge colorScheme="pink" w="fit-content" fontSize="0.7em">
              ⭐ {product.avg_rating} / 5
            </Badge>
          )}
        </Stack>

        <Button
          as={RouterLink}
          to={`/product/${product.slug}`}
          mt={4}
          size="sm"
          colorScheme="pink"
          w="full"
          rounded="md"
        >
          Lihat Detail
        </Button>
      </Box>
    </Box>
  );
}
