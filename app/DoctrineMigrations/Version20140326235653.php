<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140326235653 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE membership_package (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, price VARCHAR(10) NOT NULL, `interval` INT NOT NULL, discr VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE membership_period (id INT AUTO_INCREMENT NOT NULL, package_id INT DEFAULT NULL, createdAt DATETIME NOT NULL, range_start DATETIME NOT NULL, range_end DATETIME NOT NULL, UNIQUE INDEX UNIQ_BB05AF57F44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE membership (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE membership_periods (membership_id INT NOT NULL, period_id INT NOT NULL, INDEX IDX_EEBA0EF31FB354CD (membership_id), UNIQUE INDEX UNIQ_EEBA0EF3EC8B7ADE (period_id), PRIMARY KEY(membership_id, period_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE membership_period ADD CONSTRAINT FK_BB05AF57F44CABFF FOREIGN KEY (package_id) REFERENCES membership_package (id)");
        $this->addSql("ALTER TABLE membership_periods ADD CONSTRAINT FK_EEBA0EF31FB354CD FOREIGN KEY (membership_id) REFERENCES membership (id)");
        $this->addSql("ALTER TABLE membership_periods ADD CONSTRAINT FK_EEBA0EF3EC8B7ADE FOREIGN KEY (period_id) REFERENCES membership_period (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE membership_period DROP FOREIGN KEY FK_BB05AF57F44CABFF");
        $this->addSql("ALTER TABLE membership_periods DROP FOREIGN KEY FK_EEBA0EF3EC8B7ADE");
        $this->addSql("ALTER TABLE membership_periods DROP FOREIGN KEY FK_EEBA0EF31FB354CD");
        $this->addSql("DROP TABLE membership_package");
        $this->addSql("DROP TABLE membership_period");
        $this->addSql("DROP TABLE membership");
        $this->addSql("DROP TABLE membership_periods");
    }
}
