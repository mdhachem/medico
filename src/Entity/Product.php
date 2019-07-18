<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @Vich\Uploadable
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primaryImage;

    /**
     * @Vich\UploadableField(mapping="imagep", fileNameProperty="primaryImage")
     */
    private $imageFile1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secondaryImage1;

    /**
     * @Vich\UploadableField(mapping="images1", fileNameProperty="secondaryImage1")
     */
    private $imageFile2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secondaryImage2;

    /**
     * @Vich\UploadableField(mapping="images2", fileNameProperty="secondaryImage2")
     */
    private $imageFile3;

    /**
     * @ORM\Column(type="float")
     */
    private $price;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneCommande", mappedBy="product")
     */
    private $ligneCommandes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RawMaterial", inversedBy="products")
     */
    private $rowMaterial;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrimaryImage(): ?string
    {
        return $this->primaryImage;
    }

    public function setPrimaryImage(?string $primaryImage): self
    {
        $this->primaryImage = $primaryImage;

        return $this;
    }

    public function getSecondaryImage1(): ?string
    {
        return $this->secondaryImage1;
    }

    public function setSecondaryImage1(?string $secondaryImage1): self
    {
        $this->secondaryImage1 = $secondaryImage1;

        return $this;
    }

    public function getSecondaryImage2(): ?string
    {
        return $this->secondaryImage2;
    }

    public function setSecondaryImage2(?string $secondaryImage2): self
    {
        $this->secondaryImage2 = $secondaryImage2;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }



    /**
     * @return Collection|LigneCommande[]
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setProduct($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->removeElement($ligneCommande);
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduct() === $this) {
                $ligneCommande->setProduct(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function setImageFile1(File $image = null)
    {
        $this->imageFile1 = $image;
    }

    public function getImageFile1()
    {
        return $this->imageFile1;
    }

    public function setImageFile2(File $image = null)
    {
        $this->imageFile2 = $image;
    }

    public function getImageFile2()
    {
        return $this->imageFile2;
    }

    public function setImageFile3(File $image = null)
    {
        $this->imageFile3 = $image;
    }

    public function getImageFile3()
    {
        return $this->imageFile3;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getRowMaterial(): ?RawMaterial
    {
        return $this->rowMaterial;
    }

    public function setRowMaterial(?RawMaterial $rowMaterial): self
    {
        $this->rowMaterial = $rowMaterial;

        return $this;
    }
}
