
import {
  Box,
  Flex,
  Text,
  Button,
  Input,
  InputGroup,
  InputLeftElement,
  IconButton,
  Menu,
  MenuButton,
  MenuList,
  MenuItem,
  HStack,
  Drawer,
  DrawerBody,
  DrawerOverlay,
  DrawerContent,
  DrawerCloseButton,
  useDisclosure,
  useBreakpointValue,
  Stack,
} from "@chakra-ui/react";
import {
  FaSearch,
  FaHeart,
  FaShoppingCart,
  FaChevronDown,
  FaBars,
} from "react-icons/fa";
import { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";

axios.defaults.withCredentials = true;

export default function Navbar() {
  const { isOpen, onOpen, onClose } = useDisclosure();
  const isMobile = useBreakpointValue({ base: true, md: false });
  const navigate = useNavigate();

  const [categories, setCategories] = useState([]);
  const [wishlistCount, setWishlistCount] = useState(0);
  const [cartCount, setCartCount] = useState(0);
  const [user, setUser] = useState(null);

  useEffect(() => {
    axios
      .get("http://localhost:8080/api/categories")
      .then((res) => setCategories(res.data.data || []))
      .catch((err) => console.error("Gagal ambil kategori", err));
  }, []);

  useEffect(() => {
    axios
      .get("http://localhost:8080/api/cart/count")
      .then((res) => {
        if (res.data.status) setCartCount(res.data.count);
      })
      .catch((err) => console.error("Gagal ambil cart count", err));
  }, []);

  useEffect(() => {
    axios
      .get("http://localhost:8080/api/wishlist")
      .then((res) => {
        if (res.data.status) {
          setWishlistCount(res.data.wishlist.length || 0);
        }
      })
      .catch((err) => console.error("Gagal ambil wishlist", err));
  }, []);

  useEffect(() => {
    axios
      .get("http://localhost:8080/api/account")
      .then((res) => {
        if (res.data.status) setUser(res.data.user);
      })
      .catch(() => setUser(null));
  }, []);

  const handleLogout = async () => {
    try {
      await axios.post("http://localhost:8080/api/auth/logout");
      setUser(null);
      navigate("/");
      window.location.reload();
    } catch (err) {
      console.error("Gagal logout", err);
    }
  };

  return (
    <Box
      bg="white"
      px={{ base: 4, md: 8 }}
      py={3}
      shadow="sm"
      position="sticky"
      top={0}
      zIndex={10}
    >
      <Flex
        align="center"
        justify="space-between"
        maxW="1200px"
        mx="auto"
        flexWrap="wrap"
      >
        <HStack spacing={4}>
          <Text fontSize="2xl" fontWeight="bold" color="pink.500" pr={2}>
            Sven Store
          </Text>

          {!isMobile && (
            <Menu>
              <MenuButton
                as={Button}
                size="sm"
                variant="outline"
                colorScheme="pink"
                rightIcon={<FaChevronDown />}
              >
                Kategori
              </MenuButton>
              <MenuList>
                {categories.map((cat) => (
                  <Link key={cat.id} to={`/category/${cat.slug}`}>
                    <MenuItem>{cat.name}</MenuItem>
                  </Link>
                ))}
              </MenuList>
            </Menu>
          )}
        </HStack>

        {!isMobile && (
          <InputGroup flex="1" maxW="400px" mx={4}>
            <InputLeftElement>
              <FaSearch color="gray.400" />
            </InputLeftElement>
            <Input placeholder="Cari di Sven Store" bg="gray.50" />
          </InputGroup>
        )}

        {!isMobile ? (
          <HStack spacing={3}>
            <Box position="relative">
              <Link to="/wishlist">
                <IconButton
                  icon={<FaHeart />}
                  aria-label="Wishlist"
                  variant="ghost"
                  color="gray.500"
                  fontSize="lg"
                  _hover={{ color: "pink.500", bg: "gray.100" }}
                />
              </Link>
              {wishlistCount > 0 && (
                <Box
                  position="absolute"
                  top="-1"
                  right="-1"
                  bg="pink.400"
                  color="white"
                  fontSize="xs"
                  px={2}
                  py={0.5}
                  borderRadius="full"
                  minW="5"
                  textAlign="center"
                >
                  {wishlistCount}
                </Box>
              )}
            </Box>

            <Box position="relative">
              <Link to="/cart">
                <IconButton
                  icon={<FaShoppingCart />}
                  aria-label="Cart"
                  variant="ghost"
                  color="gray.500"
                  fontSize="lg"
                  _hover={{ color: "pink.500", bg: "gray.100" }}
                />
              </Link>
              {cartCount > 0 && (
                <Box
                  position="absolute"
                  top="0"
                  right="0"
                  bg="pink.400"
                  color="white"
                  fontSize="xs"
                  px={1.5}
                  py={0.5}
                  borderRadius="full"
                >
                  {cartCount}
                </Box>
              )}
            </Box>

            {user ? (
              <Menu>
                <MenuButton as={Button} size="sm" rightIcon={<FaChevronDown />} colorScheme="pink">
                  {user.username}
                </MenuButton>
                <MenuList>
                  <MenuItem as={Link} to="/profile">Profil</MenuItem>
                  <MenuItem onClick={handleLogout}>Keluar</MenuItem>
                </MenuList>
              </Menu>
            ) : (
              <Link to="/auth">
                <Button size="sm" colorScheme="pink">
                  Masuk / Daftar
                </Button>
              </Link>
            )}
          </HStack>
        ) : (
          <IconButton icon={<FaBars />} aria-label="Menu" onClick={onOpen} />
        )}
      </Flex>

      <Drawer placement="right" onClose={onClose} isOpen={isOpen}>
        <DrawerOverlay />
        <DrawerContent>
          <DrawerCloseButton />
          <DrawerBody pt={10}>
            <Stack spacing={4}>
              <Menu>
                <MenuButton
                  as={Button}
                  variant="outline"
                  colorScheme="pink"
                  rightIcon={<FaChevronDown />}
                >
                  Kategori
                </MenuButton>
                <MenuList>
                  {categories.map((cat) => (
                    <Link key={cat.id} to={`/category/${cat.slug}`} onClick={onClose}>
                      <MenuItem>{cat.name}</MenuItem>
                    </Link>
                  ))}
                </MenuList>
              </Menu>

              <InputGroup>
                <InputLeftElement>
                  <FaSearch color="gray.400" />
                </InputLeftElement>
                <Input placeholder="Cari di Sven Store" bg="gray.50" />
              </InputGroup>

              <Link to="/wishlist" onClick={onClose}>
                <Button leftIcon={<FaHeart />} variant="ghost" justifyContent="start" width="full">
                  Wishlist
                </Button>
              </Link>
              <Link to="/cart" onClick={onClose}>
                <Button leftIcon={<FaShoppingCart />} variant="ghost" justifyContent="start" width="full">
                  Keranjang
                </Button>
              </Link>

              {user ? (
                <>
                  <Button colorScheme="pink" width="full" onClick={onClose} as={Link} to="/profile">
                    Profil
                  </Button>
                  <Button onClick={handleLogout} variant="outline" width="full">
                    Keluar
                  </Button>
                </>
              ) : (
                <Link to="/auth" onClick={onClose}>
                  <Button colorScheme="pink" width="full">
                    Masuk / Daftar
                  </Button>
                </Link>
              )}
            </Stack>
          </DrawerBody>
        </DrawerContent>
      </Drawer>
    </Box>
  );
}
