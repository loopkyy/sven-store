import {
  Box,
  Heading,
  Text,
  Image,
  Button,
  Flex,
  Stack,
  Divider,
  IconButton,
  useToast,
  Center,
  VStack,
  Icon,
} from "@chakra-ui/react";
import { FaPlus, FaMinus, FaTrash, FaShoppingCart } from "react-icons/fa";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import { MdRemoveShoppingCart } from "react-icons/md";

axios.defaults.withCredentials = true;

export default function CartPage() {
  const [items, setItems] = useState([]);
  const toast = useToast();
  const navigate = useNavigate();

  useEffect(() => {
    fetchCart();
  }, []);

  const fetchCart = () => {
    axios
      .get("http://localhost:8080/api/cart")
      .then((res) => {
        if (res.data.status) {
          const cartObj = res.data.cart;
          const cartArr = Object.entries(cartObj).map(([key, item]) => ({
            ...item,
            cartKey: key,
            image: item.image,
          }));
          setItems(cartArr);
        }
      })
      .catch(() => {
        toast({
          title: "Gagal mengambil keranjang",
          status: "error",
          isClosable: true,
        });
      });
  };

  const updateQty = (cartKey, qty) => {
    if (qty < 1) return;
    axios
      .post("http://localhost:8080/api/cart/update", { key: cartKey, qty })
      .then(() => fetchCart())
      .catch(() => {
        toast({
          title: "Gagal mengupdate jumlah item",
          status: "error",
          isClosable: true,
        });
      });
  };

  const removeItem = (cartKey) => {
    axios
      .post("http://localhost:8080/api/cart/remove", { key: cartKey })
      .then(() => {
        fetchCart();
        toast({
          title: "Item dihapus dari keranjang",
          status: "info",
          isClosable: true,
        });
      })
      .catch(() => {
        toast({
          title: "Gagal menghapus item",
          status: "error",
          isClosable: true,
        });
      });
  };

  const total = items.reduce((sum, item) => sum + item.price * item.qty, 0);

  return (
    <Box maxW="1000px" mx="auto" px={4} py={6}>
      <Heading fontSize="2xl" mb={4}>
        Keranjang Belanja
      </Heading>

      {items.length === 0 ? (
        <Center py={20}>
          <VStack spacing={4} textAlign="center">
            <Icon as={MdRemoveShoppingCart} boxSize={16} color="gray.400" />
            <Text fontSize="lg" color="gray.500">
              Belum ada produk di keranjang kamu.
            </Text>
            <Button
              colorScheme="pink"
              onClick={() => navigate("/products")}
              leftIcon={<FaShoppingCart />}
            >
              Lihat Produk
            </Button>
          </VStack>
        </Center>
      ) : (
        <Stack spacing={4}>
          {items.map((item) => (
            <Flex
              key={item.cartKey}
              direction={{ base: "column", md: "row" }}
              align="center"
              justify="space-between"
              p={4}
              borderWidth={1}
              borderRadius="lg"
            >
              <Flex direction={{ base: "column", sm: "row" }} align="center" w="100%">
                <Image
                  src={item.image}
                  alt={item.name}
                  boxSize={{ base: "70px", md: "80px" }}
                  objectFit="cover"
                  borderRadius="md"
                  mr={{ base: 0, sm: 4 }}
                  mb={{ base: 2, sm: 0 }}
                />
                <Box flex="1">
                  <Text fontWeight="bold">{item.name}</Text>
                  <Text fontSize="sm" color="gray.500">
                    Rp{item.price.toLocaleString()}
                  </Text>
                  <Text fontSize="sm" mt={1}>
                    Subtotal: Rp{(item.price * item.qty).toLocaleString()}
                  </Text>
                </Box>
              </Flex>

              <Flex
                align="center"
                justify={{ base: "center", md: "flex-end" }}
                mt={{ base: 3, md: 0 }}
                wrap="wrap"
              >
                <IconButton
                  icon={<FaMinus />}
                  size={{ base: "xs", md: "sm" }}
                  onClick={() => updateQty(item.cartKey, item.qty - 1)}
                  mr={2}
                  aria-label="Kurangi"
                />
                <Text fontWeight="bold" w="30px" textAlign="center">
                  {item.qty}
                </Text>
                <IconButton
                  icon={<FaPlus />}
                  size={{ base: "xs", md: "sm" }}
                  onClick={() => updateQty(item.cartKey, item.qty + 1)}
                  ml={2}
                  aria-label="Tambah"
                />
                <IconButton
                  icon={<FaTrash />}
                  size={{ base: "xs", md: "sm" }}
                  colorScheme="red"
                  ml={4}
                  mt={{ base: 2, md: 0 }}
                  onClick={() => removeItem(item.cartKey)}
                  aria-label="Hapus"
                />
              </Flex>
            </Flex>
          ))}

          <Divider />

          <Flex
            direction={{ base: "column", sm: "row" }}
            justify="space-between"
            align={{ base: "stretch", sm: "center" }}
            textAlign={{ base: "left", sm: "right" }}
            gap={4}
          >
            <Text fontWeight="bold" fontSize="lg">
              Total: Rp{total.toLocaleString()}
            </Text>
            <Button
              colorScheme="pink"
              onClick={() => navigate("/checkout")}
              w={{ base: "100%", sm: "auto" }}
            >
              Lanjut ke Checkout
            </Button>
          </Flex>
        </Stack>
      )}
    </Box>
  );
}
