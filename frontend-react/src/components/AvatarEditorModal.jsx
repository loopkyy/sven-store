import React, { useRef, useState } from "react";
import AvatarEditor from "react-avatar-editor";
import {
  Modal,
  ModalOverlay,
  ModalContent,
  ModalHeader,
  ModalBody,
  ModalFooter,
  ModalCloseButton,
  Button,
  Input,
  useToast,
} from "@chakra-ui/react";
import axios from "axios";

function AvatarEditorModal({ isOpen, onClose, onUploadSuccess }) {
  const editorRef = useRef();
  const [image, setImage] = useState(null);
  const [scale, setScale] = useState(1.2);
  const toast = useToast();

  const handleUpload = async () => {
    if (!editorRef.current) return;
    const canvas = editorRef.current.getImageScaledToCanvas();
    canvas.toBlob(async (blob) => {
      const formData = new FormData();
      formData.append("avatar", blob, "avatar.png");

      try {
        const res = await axios.post("/api/account/avatar", formData); // endpoint CI4 kamu
        toast({ title: "Foto berhasil diperbarui", status: "success" });
        onUploadSuccess(res.data.avatar_url); // update avatar setelah upload
        onClose();
      } catch (err) {
        toast({ title: "Gagal upload avatar", status: "error" });
      }
    }, "image/png");
  };

  return (
    <Modal isOpen={isOpen} onClose={onClose} isCentered>
      <ModalOverlay />
      <ModalContent>
        <ModalHeader>Edit Foto Profil</ModalHeader>
        <ModalCloseButton />
        <ModalBody>
          <Input
            type="file"
            accept="image/*"
            onChange={(e) => setImage(e.target.files[0])}
            mb={4}
          />
          {image && (
            <>
              <AvatarEditor
                ref={editorRef}
                image={image}
                width={250}
                height={250}
                border={30}
                borderRadius={125}
                scale={scale}
              />
              <Input
                type="range"
                min="1"
                max="3"
                step="0.01"
                value={scale}
                onChange={(e) => setScale(parseFloat(e.target.value))}
                mt={4}
              />
            </>
          )}
        </ModalBody>
        <ModalFooter>
          <Button onClick={onClose} mr={3}>
            Batal
          </Button>
          <Button onClick={handleUpload} colorScheme="blue" isDisabled={!image}>
            Simpan
          </Button>
        </ModalFooter>
      </ModalContent>
    </Modal>
  );
}

export default AvatarEditorModal;
