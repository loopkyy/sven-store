import { useEffect, useState } from "react";
import axios from "axios";
import {
  Box,
  Button,
  Heading,
  Input,
  Select,
  Stack,
  Text,
  VStack,
  useToast,
  Image,
  HStack,
  IconButton,
} from "@chakra-ui/react";
import { FaPlus, FaMinus } from "react-icons/fa";

const CheckoutPage = () => {
  const toast = useToast();
  const [cartItems, setCartItems] = useState([]);
  const [cartTotal, setCartTotal] = useState(0);

  // Alamat manual
  const [receiverName, setReceiverName] = useState("");
  const [rt, setRt] = useState("");
  const [rw, setRw] = useState("");
  const [village, setVillage] = useState("");
  const [district, setDistrict] = useState("");
  const [city, setCity] = useState("");
  const [province, setProvince] = useState("");
  const [postalCode, setPostalCode] = useState("");

  const [paymentMethod, setPaymentMethod] = useState("");

  const fetchCart = async () => {
    try {
      const res = await axios.get("http://localhost:8080/api/cart");
      if (res.data.status) {
        const cartObj = res.data.cart;
        const cartArr = Object.entries(cartObj).map(([key, item]) => ({
          ...item,
          cartKey: key,
        }));

        setCartItems(cartArr);
        const total = cartArr.reduce((sum, item) => sum + item.price * item.qty, 0);
        setCartTotal(total);
      }
    } catch (error) {
      console.error("Gagal mengambil keranjang:", error);
    }
  };

  const updateCartQty = async (cartKey, qty) => {
    try {
      await axios.post("http://localhost:8080/api/cart/update", {
        key: cartKey,
        qty,
      });
      fetchCart(); // Refresh data setelah update
    } catch (error) {
      toast({
        title: "Gagal memperbarui jumlah",
        status: "error",
        isClosable: true,
      });
    }
  };

  const handleQtyChange = (item, newQty) => {
    const qty = parseInt(newQty);
    if (qty < 1) return;
    updateCartQty(item.cartKey, qty);
  };

  const handleCheckout = () => {
    toast({
      title: "Checkout berhasil (simulasi)",
      status: "success",
    });
  };

  useEffect(() => {
    fetchCart();
  }, []);

  return (
    <Box p={4}>
      <Heading mb={6}>Checkout</Heading>
      <Stack direction={{ base: "column", md: "row" }} spacing={6} align="start">
        {/* Kiri: Form Alamat */}
        <VStack spacing={4} flex="2" align="stretch">
          <Box>
            <Text fontWeight="bold">Nama Penerima</Text>
            <Input
              placeholder="Masukkan nama penerima"
              value={receiverName}
              onChange={(e) => setReceiverName(e.target.value)}
            />
          </Box>

          <Box>
            <Text fontWeight="bold">Alamat Pengiriman</Text>
            <HStack spacing={2}>
              <Input
                placeholder="RT"
                value={rt}
                onChange={(e) => setRt(e.target.value)}
              />
              <Input
                placeholder="RW"
                value={rw}
                onChange={(e) => setRw(e.target.value)}
              />
            </HStack>
            <Input
              placeholder="Desa / Kelurahan"
              value={village}
              onChange={(e) => setVillage(e.target.value)}
              mt={2}
            />
            <Input
              placeholder="Kecamatan"
              value={district}
              onChange={(e) => setDistrict(e.target.value)}
              mt={2}
            />
            <Input
              placeholder="Kabupaten / Kota"
              value={city}
              onChange={(e) => setCity(e.target.value)}
              mt={2}
            />
            <Input
              placeholder="Provinsi"
              value={province}
              onChange={(e) => setProvince(e.target.value)}
              mt={2}
            />
            <Input
              placeholder="Kode Pos"
              value={postalCode}
              onChange={(e) => setPostalCode(e.target.value)}
              mt={2}
            />
          </Box>

          <Box>
            <Text fontWeight="bold">Metode Pembayaran</Text>
            <Select
              placeholder="Pilih metode"
              value={paymentMethod}
              onChange={(e) => setPaymentMethod(e.target.value)}
            >
              <option value="cod">Bayar di Tempat (COD)</option>
              <option value="bank_transfer">Transfer Bank</option>
            </Select>
          </Box>
        </VStack>

        {/* Kanan: Ringkasan */}
        <Box flex="1" borderWidth="1px" borderRadius="md" p={4}>
          <Text fontWeight="bold" mb={2}>Ringkasan Belanja</Text>
          <VStack align="stretch" spacing={4}>
            {cartItems.map((item) => (
              <Box key={item.cartKey} borderWidth="1px" borderRadius="md" p={2}>
                <HStack spacing={3}>
                  <Image
                    src={item.image}
                    alt={item.name}
                    boxSize="60px"
                    objectFit="cover"
                  />
                  <Box flex="1">
                    <Text fontWeight="bold">{item.name}</Text>
                    <Text fontSize="sm">Harga: Rp {item.price.toLocaleString("id-ID")}</Text>
                    <HStack mt={2}>
                      <IconButton
                        icon={<FaMinus />}
                        size="sm"
                        onClick={() => handleQtyChange(item, item.qty - 1)}
                        aria-label="Kurangi"
                      />
                      <Input
                        type="number"
                        value={item.qty}
                        min="1"
                        onChange={(e) => handleQtyChange(item, e.target.value)}
                        width="60px"
                      />
                      <IconButton
                        icon={<FaPlus />}
                        size="sm"
                        onClick={() => handleQtyChange(item, item.qty + 1)}
                        aria-label="Tambah"
                      />
                    </HStack>
                  </Box>
                </HStack>
              </Box>
            ))}
            <Text>Total Belanja: Rp {cartTotal.toLocaleString("id-ID")}</Text>
            <Text fontWeight="bold">
              Total Akhir: Rp {cartTotal.toLocaleString("id-ID")}
            </Text>
            <Button colorScheme="teal" onClick={handleCheckout}>
              Proses Checkout
            </Button>
          </VStack>
        </Box>
      </Stack>
    </Box>
  );
};

export default CheckoutPage;
