import { useState } from 'react';
import {
  Box, Button, Input, VStack, Heading, useToast,
  Tabs, TabList, TabPanels, Tab, TabPanel, Textarea, InputGroup,
  InputRightElement, IconButton
} from '@chakra-ui/react';
import { ViewIcon, ViewOffIcon } from '@chakra-ui/icons';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

const AuthPage = () => {
  const [tabIndex, setTabIndex] = useState(0);
  const [showPassword, setShowPassword] = useState(false);
  const [loginData, setLoginData] = useState({ email: '', password: '' });
  const [registerData, setRegisterData] = useState({
    username: '',
    email: '',
    password: '',
    phone: '',
    address: ''
  });

  const toast = useToast();
  const navigate = useNavigate();

  const handleLogin = async () => {
    const { email, password } = loginData;

    if (!email || !password) {
      toast({ title: 'Email dan password wajib diisi.', status: 'warning' });
      return;
    }

    try {
      const res = await axios.post('http://localhost:8080/api/auth/login', loginData, {
        withCredentials: true
      });
      toast({ title: 'Berhasil login', status: 'success' });
      navigate('/');
    } catch (err) {
      toast({
        title: 'Gagal login',
        description: err.response?.data?.message || 'Terjadi kesalahan.',
        status: 'error',
      });
    }
  };

  const handleRegister = async () => {
    const { username, email, password, phone, address } = registerData;

    if (!username || !email || !password || !phone || !address) {
      toast({ title: 'Semua kolom wajib diisi.', status: 'warning' });
      return;
    }

    const nameRegex = /^[a-zA-Z\s]+$/;
    if (!nameRegex.test(username)) {
      toast({ title: 'Nama hanya boleh berisi huruf.', status: 'warning' });
      return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      toast({ title: 'Format email tidak valid.', status: 'warning' });
      return;
    }

    if (password.length < 6) {
      toast({ title: 'Password minimal 6 karakter.', status: 'warning' });
      return;
    }

    const phoneRegex = /^08[0-9]{8,11}$/;
    if (!phoneRegex.test(phone)) {
      toast({ title: 'Nomor telepon harus format Indonesia (08...) dan 10–13 digit.', status: 'warning' });
      return;
    }

    if (address.trim().length < 10) {
      toast({ title: 'Alamat harus lebih lengkap (minimal 10 karakter).', status: 'warning' });
      return;
    }

    try {
      await axios.post('http://localhost:8080/api/auth/register', registerData);
      toast({ title: 'Berhasil daftar, silakan masuk.', status: 'success' });
      setRegisterData({ username: '', email: '', password: '', phone: '', address: '' });
      setTabIndex(0);
    } catch (err) {
      toast({
        title: 'Gagal daftar',
        description: err.response?.data?.message || 'Terjadi kesalahan.',
        status: 'error',
      });
    }
  };

  return (
    <Box maxW="md" mx="auto" mt={10} p={6} borderWidth={1} borderRadius="lg" boxShadow="md">
      <Tabs isFitted variant="enclosed" index={tabIndex} onChange={setTabIndex}>
        <TabList mb="1em">
          <Tab>Masuk</Tab>
          <Tab>Daftar</Tab>
        </TabList>
        <TabPanels>
          {/* Panel Masuk */}
          <TabPanel>
            <VStack spacing={4}>
              <Heading size="md">Masuk ke akunmu</Heading>
              <Input placeholder="Email"
                value={loginData.email}
                onChange={e => setLoginData({ ...loginData, email: e.target.value })}
              />
              <InputGroup>
                <Input placeholder="Password" type={showPassword ? 'text' : 'password'}
                  value={loginData.password}
                  onChange={e => setLoginData({ ...loginData, password: e.target.value })}
                />
                <InputRightElement>
                  <IconButton
                    variant="ghost"
                    icon={showPassword ? <ViewOffIcon /> : <ViewIcon />}
                    onClick={() => setShowPassword(!showPassword)}
                    aria-label="Toggle password visibility"
                  />
                </InputRightElement>
              </InputGroup>
              <Button colorScheme="blue" w="full" onClick={handleLogin}>Masuk</Button>
            </VStack>
          </TabPanel>

          {/* Panel Daftar */}
          <TabPanel>
            <VStack spacing={4}>
              <Heading size="md">Buat akun baru</Heading>
              <Input placeholder="Nama Lengkap"
                value={registerData.username}
                onChange={e => setRegisterData({ ...registerData, username: e.target.value })}
              />
              <Input placeholder="Email"
                value={registerData.email}
                onChange={e => setRegisterData({ ...registerData, email: e.target.value })}
              />
              <InputGroup>
                <Input placeholder="Password" type={showPassword ? 'text' : 'password'}
                  value={registerData.password}
                  onChange={e => setRegisterData({ ...registerData, password: e.target.value })}
                />
                <InputRightElement>
                  <IconButton
                    variant="ghost"
                    icon={showPassword ? <ViewOffIcon /> : <ViewIcon />}
                    onClick={() => setShowPassword(!showPassword)}
                    aria-label="Toggle password visibility"
                  />
                </InputRightElement>
              </InputGroup>
              <Input placeholder="Nomor Telepon (08...)"
                value={registerData.phone}
                onChange={e => setRegisterData({ ...registerData, phone: e.target.value })}
              />
              <Textarea placeholder="Alamat Lengkap"
                value={registerData.address}
                onChange={e => setRegisterData({ ...registerData, address: e.target.value })}
              />
              <Button colorScheme="green" w="full" onClick={handleRegister}>Daftar</Button>
            </VStack>
          </TabPanel>
        </TabPanels>
      </Tabs>
    </Box>
  );
};

export default AuthPage;
