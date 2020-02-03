<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BandRepository")
 */
class Band
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Folder", mappedBy="band")
     */
    private $folders;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Musician", mappedBy="bands")
     */
    private $musicians;

    public function __construct()
    {
        $this->folders = new ArrayCollection();
        $this->musicians = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Folder[]
     */
    public function getFolders(): Collection
    {
        return $this->folders;
    }

    public function addFolder(Folder $folder): self
    {
        if (!$this->folders->contains($folder)) {
            $this->folders[] = $folder;
            $folder->setBand($this);
        }

        return $this;
    }

    public function removeFolder(Folder $folder): self
    {
        if ($this->folders->contains($folder)) {
            $this->folders->removeElement($folder);
            // set the owning side to null (unless already changed)
            if ($folder->getBand() === $this) {
                $folder->setBand(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Musician[]
     */
    public function getMusicians(): Collection
    {
        return $this->musicians;
    }

    public function addMusician(Musician $musician): self
    {
        if (!$this->musicians->contains($musician)) {
            $this->musicians[] = $musician;
            $musician->addBand($this);
        }

        return $this;
    }

    public function removeMusician(Musician $musician): self
    {
        if ($this->musicians->contains($musician)) {
            $this->musicians->removeElement($musician);
            $musician->removeBand($this);
        }

        return $this;
    }
}
