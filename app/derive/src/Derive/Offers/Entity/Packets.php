<?php namespace Derive\Offers\Entity;

use Derive\Offers\Record\Packet;
use Pckg\Database\Entity;
use Pckg\Database\Relation\HasMany;
use Pckg\Database\Repository;

class Packets extends Entity
{

    protected $record = Packet::class;

    protected $repositoryName = Repository::class . '.gnp';

    public function voucherTab()
    {
        return $this->hasOne(PacketsTabs::class)
                    ->foreignKey('packet_id')
                    ->fill('voucherTab')
                    ->where('picture', null, 'IS NOT');
    }

    public function forOrderForm()
    {
        return $this->published()
                    ->available()
                    ->withAdditions(
                        function(HasMany $additions) {
                            $additions->published();
                            $additions->available();
                        }
                    );
    }

    public function published()
    {
        return $this->where('dt_published');
    }

    public function available()
    {
        return $this;
    }

}