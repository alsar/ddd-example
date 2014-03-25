<?php
namespace Alsar\Ddd\Domain\Membership;

interface MembershipRepository
{
    /**
     * @param integer $id
     *
     * @return Membership|null
     */
    public function find($id);

    /**
     * @return ArrayCollection|Membership[]
     */
    public function findAll();

    /**
     * @param Membership $membership
     */
    public function add(Membership $membership);

    /**
     * @param Membership $membership
     */
    public function remove(Membership $membership);
}
