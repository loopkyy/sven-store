import { useEffect, useState, useRef } from "react";
import axios from "axios";
import AvatarEditor from "react-avatar-editor";
import {
  Box,
  Heading,
  Text,
  Spinner,
  SimpleGrid,
  Avatar,
  VStack,
  Divider,
  Flex,
  useColorModeValue,
  Button,
  Modal,
  ModalOverlay,
  ModalContent,
  ModalHeader,
  ModalCloseButton,
  ModalBody,
  ModalFooter,
  Input,
  useDisclosure,
  useToast,
} from "@chakra-ui/react";
import { FaCamera } from "react-icons/fa";

const ProfilePage = () => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);
  const [form, setForm] = useState({
    username: "",
    email: "",
    phone: "",
    address: "",
  });

  const [profileImage, setProfileImage] = useState(null);
  const [selectedImage, setSelectedImage] = useState(null);
  const editorRef = useRef(null);

  const inputFileRef = useRef(null);
  const { isOpen, onOpen, onClose } = useDisclosure();
  const {
    isOpen: isEditorOpen,
    onOpen: openEditor,
    onClose: closeEditor,
  } = useDisclosure();

  const toast = useToast();

  const cardBg = useColorModeValue("white", "gray.800");
  const fieldBg = useColorModeValue("gray.100", "gray.700");

  const fetchUser = () => {
    setLoading(true);
    axios
      .get("http://localhost:8080/api/account", { withCredentials: true })
      .then((res) => {
        if (res.data.status) {
          const u = res.data.user;
          setUser(u);
          setForm({
            username: u.username,
            email: u.email,
            phone: u.phone || "",
            address: u.address || "",
          });
          setProfileImage(u.avatar_url || null);
        }
      })
      .catch((err) => {
        console.error("Gagal ambil data profil:", err);
      })
      .finally(() => setLoading(false));
  };

  useEffect(() => {
    fetchUser();
  }, []);

  const handleChange = (e) => {
    setForm((prev) => ({ ...prev, [e.target.name]: e.target.value }));
  };

  const handleImageClick = () => {
    inputFileRef.current?.click();
  };

  const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setSelectedImage(file);
      openEditor();
    }
  };

  const handleCropAndUpload = () => {
    if (editorRef.current) {
      const canvas = editorRef.current.getImage();
      canvas.toBlob((blob) => {
        const data = new FormData();
        data.append("avatar", blob, "avatar.png");

        axios
          .post("http://localhost:8080/api/account/avatar", data, {
            withCredentials: true,
            headers: { "Content-Type": "multipart/form-data" },
          })
          .then((res) => {
            if (res.data.status) {
              toast({
                title: "Foto profil berhasil diubah.",
                status: "success",
                duration: 3000,
                isClosable: true,
              });
              closeEditor();
              fetchUser();
            } else {
              toast({
                title: "Gagal mengubah foto profil.",
                description: res.data.message || "Terjadi kesalahan",
                status: "error",
                duration: 3000,
                isClosable: true,
              });
            }
          })
          .catch((err) => {
            const msg =
              err.response?.data?.messages ||
              err.response?.data?.message ||
              "Terjadi kesalahan";
            toast({
              title: "Gagal mengubah foto profil.",
              description:
                typeof msg === "object" ? Object.values(msg).join(", ") : msg,
              status: "error",
              duration: 4000,
              isClosable: true,
            });
          });
      }, "image/png");
    }
  };

  const handleUpdate = () => {
    const data = {
      username: form.username,
      email: form.email,
      phone: form.phone,
      address: form.address,
    };

    axios
      .put("http://localhost:8080/api/account/update", data, {
        withCredentials: true,
      })
      .then((res) => {
        if (res.data.status) {
          toast({
            title: "Profil berhasil diperbarui.",
            status: "success",
            duration: 3000,
            isClosable: true,
          });
          onClose();
          fetchUser();
        } else {
          toast({
            title: "Gagal memperbarui profil.",
            description: res.data.message || "Terjadi kesalahan",
            status: "error",
            duration: 3000,
            isClosable: true,
          });
        }
      })
      .catch((err) => {
        const msg =
          err.response?.data?.messages ||
          err.response?.data?.message ||
          "Terjadi kesalahan";
        toast({
          title: "Gagal memperbarui profil.",
          description:
            typeof msg === "object" ? Object.values(msg).join(", ") : msg,
          status: "error",
          duration: 4000,
          isClosable: true,
        });
      });
  };

  if (loading) return <Spinner mt={10} />;

  const data = [
    { label: "Nama", value: user.username },
    { label: "Email", value: user.email },
    { label: "Telepon", value: user.phone || "-" },
    { label: "Alamat", value: user.address || "-" },
  ];

  return (
    <>
      <Flex justify="center" py={10}>
        <Box
          w={{ base: "90%", md: "600px" }}
          bg={cardBg}
          boxShadow="xl"
          rounded="2xl"
          p={8}
        >
          <VStack spacing={6}>
            <Box position="relative" role="group">
              <Avatar
                size="xl"
                name={form.username}
                src={profileImage}
                cursor="pointer"
                onClick={handleImageClick}
                _groupHover={{ opacity: 0.7 }}
              />
              <Box
                position="absolute"
                top="50%"
                left="50%"
                transform="translate(-50%, -50%)"
                opacity={0}
                transition="opacity 0.2s"
                _groupHover={{ opacity: 1 }}
                pointerEvents="none"
              >
                <FaCamera size={24} color="white" />
              </Box>
              <Input
                ref={inputFileRef}
                type="file"
                accept="image/*"
                display="none"
                onChange={handleImageChange}
              />
            </Box>

            <Heading size="lg">Profil Pengguna</Heading>
            <Divider />

            <SimpleGrid columns={{ base: 1, md: 2 }} spacing={4} w="100%">
              {data.map((item, index) => (
                <Box
                  key={index}
                  bg={fieldBg}
                  p={4}
                  rounded="xl"
                  boxShadow="md"
                  transition="all 0.2s"
                  _hover={{
                    transform: "translateY(-4px)",
                    boxShadow: "0 0 0 3px pink",
                  }}
                >
                  <Text fontWeight="bold" mb={1}>
                    {item.label}
                  </Text>
                  <Text>{item.value}</Text>
                </Box>
              ))}
            </SimpleGrid>

            <Button colorScheme="pink" onClick={onOpen}>
              Edit Profil
            </Button>
          </VStack>
        </Box>
      </Flex>

      {/* Modal Edit Profil */}
      <Modal isOpen={isOpen} onClose={onClose} isCentered>
        <ModalOverlay />
        <ModalContent>
          <ModalHeader>Edit Profil</ModalHeader>
          <ModalCloseButton />
          <ModalBody>
            <VStack spacing={4}>
              <Input
                placeholder="Nama"
                name="username"
                value={form.username}
                onChange={handleChange}
              />
              <Input
                placeholder="Email"
                name="email"
                value={form.email}
                onChange={handleChange}
              />
              <Input
                placeholder="Nomor Telepon"
                name="phone"
                value={form.phone}
                onChange={handleChange}
              />
              <Input
                placeholder="Alamat"
                name="address"
                value={form.address}
                onChange={handleChange}
              />
            </VStack>
          </ModalBody>
          <ModalFooter>
            <Button mr={3} onClick={onClose}>
              Batal
            </Button>
            <Button colorScheme="pink" onClick={handleUpdate}>
              Simpan
            </Button>
          </ModalFooter>
        </ModalContent>
      </Modal>

      {/* Modal Crop Avatar */}
      <Modal isOpen={isEditorOpen} onClose={closeEditor} isCentered size="xl">
        <ModalOverlay />
        <ModalContent>
          <ModalHeader>Crop Foto Profil</ModalHeader>
          <ModalCloseButton />
          <ModalBody>
            {selectedImage && (
              <AvatarEditor
                ref={editorRef}
                image={selectedImage}
                width={250}
                height={250}
                border={50}
                borderRadius={125}
                color={[255, 255, 255, 0.6]}
                scale={1.2}
                rotate={0}
              />
            )}
          </ModalBody>
          <ModalFooter>
            <Button mr={3} onClick={closeEditor}>
              Batal
            </Button>
            <Button colorScheme="pink" onClick={handleCropAndUpload}>
              Simpan
            </Button>
          </ModalFooter>
        </ModalContent>
      </Modal>
    </>
  );
};

export default ProfilePage;