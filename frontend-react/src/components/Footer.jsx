import {
  Box,
  chakra,
  Container,
  Stack,
  Text,
  Link,
  VisuallyHidden,
  useColorModeValue,
  SimpleGrid,
} from '@chakra-ui/react';
import { FaInstagram, FaTwitter, FaFacebook } from 'react-icons/fa';

const SocialButton = ({ children, label, href }) => (
  <chakra.button
    bg={useColorModeValue('blackAlpha.100', 'whiteAlpha.100')}
    rounded="full"
    w={8}
    h={8}
    cursor="pointer"
    as="a"
    href={href}
    target="_blank"
    display="inline-flex"
    alignItems="center"
    justifyContent="center"
    transition="all 0.3s ease"
    color={useColorModeValue('gray.600', 'gray.300')} // Warna default icon
    _hover={{
      bg: useColorModeValue('blackAlpha.200', 'whiteAlpha.200'),
      color: 'pink.400', // Warna icon saat hover
      transform: 'scale(1.1)', // Sedikit animasi
    }}
  >
    <VisuallyHidden>{label}</VisuallyHidden>
    {children}
  </chakra.button>
);

export default function Footer() {
  return (
    <Box
      bg={useColorModeValue('gray.100', 'gray.900')}
      color={useColorModeValue('gray.700', 'gray.200')}
      mt={12}
    >
      <Container as={Stack} maxW="6xl" py={10}>
        <SimpleGrid
          templateColumns={{ sm: '1fr 1fr', md: '2fr 1fr 1fr' }}
          spacing={8}
        >
          <Stack spacing={6}>
            <Text fontSize="2xl" fontWeight="bold" color="pink.500">
              Sven Store
            </Text>
            <Text fontSize="sm">
              Toko online fashion kekinian. Temukan gaya terbaikmu di sini!
            </Text>
          </Stack>

          <Stack align="flex-start">
            <Text fontWeight="bold" mb={2}>
              Navigasi
            </Text>
            <Link href="/">Beranda</Link>
            <Link href="/products">Produk</Link>
            <Link href="/about">Tentang Kami</Link>
            <Link href="/contact">Kontak</Link>
          </Stack>

          <Stack align="flex-start">
            <Text fontWeight="bold" mb={2}>
              Sosial Media
            </Text>
            <Stack direction="row" spacing={3}>
              <SocialButton label="Instagram" href="https://instagram.com/">
                <FaInstagram />
              </SocialButton>
              <SocialButton label="Twitter" href="https://twitter.com/">
                <FaTwitter />
              </SocialButton>
              <SocialButton label="Facebook" href="https://facebook.com/">
                <FaFacebook />
              </SocialButton>
            </Stack>
          </Stack>
        </SimpleGrid>
      </Container>

      <Box
        borderTopWidth={1}
        borderStyle="solid"
        borderColor={useColorModeValue('gray.200', 'gray.700')}
      >
        <Container
          as={Stack}
          maxW="6xl"
          py={4}
          direction={{ base: 'column', md: 'row' }}
          spacing={4}
          justify="space-between"
          align="center"
        >
<Link
  href="https://github.com/loopkyy"
  isExternal
  fontSize="sm"
  color="gray.500"
  textAlign="center"
  w="100%"
  py={4}
  _hover={{ color: 'pink.400', textDecoration: 'underline' }}
>
  © {new Date().getFullYear()} Sven Store. All rights reserved.
</Link>

        </Container>
      </Box>
    </Box>
  );
}
