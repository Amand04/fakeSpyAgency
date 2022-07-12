<?php

namespace App\Entity;

use App\Repository\MissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MissionsRepository::class)
 * @UniqueEntity("title")
 * @UniqueEntity("namecode")
 */
class Missions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 30)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Le titre ne peut pas contenir de chiffre."
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 15,
     *      max = 255)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="La description ne peut pas contenir de chiffre."
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 30)
     */
    private $namecode;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $created_at;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $closed_at;



    /**
     * @ORM\ManyToMany(targetEntity=Contacts::class, inversedBy="missions")
     */
    private $contacts;

    /**
     * @ORM\ManyToMany(targetEntity=Targets::class, inversedBy="missions")
     */
    private $targets;



    /**
     * @ORM\ManyToOne(targetEntity=Skills::class, inversedBy="missions")
     */
    private $skills;

    /**
     * @ORM\ManyToOne(targetEntity=Hideout::class, inversedBy="missions")
     */
    private $hideout;

    /**
     * @ORM\ManyToMany(targetEntity=Agents::class, inversedBy="missions")
     */
    private $agents;


    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->targets = new ArrayCollection();
        $this->agents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNamecode(): ?string
    {
        return $this->namecode;
    }

    public function setNamecode(string $namecode): self
    {
        $this->namecode = $namecode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getClosedAt(): ?\DateTimeInterface
    {
        return $this->closed_at;
    }

    public function setClosedAt(\DateTimeInterface $closed_at): self
    {
        $this->closed_at = $closed_at;

        return $this;
    }

    /**
     * @return Collection<int, Contacts>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contacts $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
        }

        return $this;
    }

    public function removeContact(Contacts $contact): self
    {
        $this->contacts->removeElement($contact);

        return $this;
    }

    /**
     * @return Collection<int, Targets>
     */
    public function getTargets(): Collection
    {
        return $this->targets;
    }

    public function addTarget(Targets $target): self
    {
        if (!$this->targets->contains($target)) {
            $this->targets[] = $target;
        }

        return $this;
    }

    public function removeTarget(Targets $target): self
    {
        $this->targets->removeElement($target);

        return $this;
    }



    public function getSkills(): ?Skills
    {
        return $this->skills;
    }

    public function setSkills(?Skills $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function getHideout(): ?Hideout
    {
        return $this->hideout;
    }

    public function setHideout(?Hideout $hideout): self
    {
        $this->hideout = $hideout;

        return $this;
    }

    /**
     * @return Collection<int, Agents>
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agents $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
        }

        return $this;
    }

    public function removeAgent(Agents $agent): self
    {
        $this->agents->removeElement($agent);

        return $this;
    }

    public function hideoutValid()
    {
        $dataCountry = $this->country;
        $dataHideout = $this->hideout;

        if ($dataCountry != $dataHideout->getCountry()) {
            return false;
        }

        return true;
    }

    public function agentsSkillsValid()
    {
        $dataSkills = $this->skills;
        $dataAgents = $this->agents;

        $agentsSkillsVal = 0;

        foreach ($dataAgents as $agent) {
            $agentSkills = $agent->displaySkills();
            if (in_array($dataSkills->getName(), $agentSkills)) {
                $agentsSkillsVal += 1;
            }
            if ($agentsSkillsVal == 0) {
                return false;
            }
        }
        return true;
    }

    public function agentsNationalityValid()
    {
        $dataAgents = $this->agents;
        $dataTargets = $this->targets;

        foreach ($dataAgents as $agent) {
            foreach ($dataTargets as $target) {
                if ($agent->getNationality() == $target->getNationality()) {
                    return false;
                }
            }
        }
        return true;
    }

    public function contactsValid()
    {
        $dataContacts = $this->contacts;
        $dataCountry = $this->country;

        foreach ($dataContacts as $contact) {
            if ($dataCountry != $contact->getNationality()) {
                return false;
            }
        }
        return true;
    }






    public function missionValid()
    {
        if (!$this->contactsValid() || !$this->hideoutValid() || !$this->agentsSkillsValid() || !$this->agentsNationalityValid()) {
            return false;
        }
        return true;
    }
}
