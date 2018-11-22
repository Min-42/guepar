<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181122144634 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, categorie VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, file_extension VARCHAR(255) NOT NULL, file_size VARCHAR(255) NOT NULL, attached_to VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, created_by VARCHAR(255) NOT NULL, INDEX IDX_D8698A76A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, code_siren VARCHAR(9) NOT NULL, nom VARCHAR(255) NOT NULL, contacts LONGTEXT NOT NULL, convention_collective VARCHAR(4) NOT NULL, tranche_effectifs VARCHAR(255) NOT NULL, nb_adherents INT NOT NULL, notes LONGTEXT NOT NULL, created_at DATETIME NOT NULL, created_by VARCHAR(255) NOT NULL, modified_at DATETIME NOT NULL, modified_by VARCHAR(255) NOT NULL, deleted_at DATETIME NOT NULL, deleted_by VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76A4AEAFEA');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE entreprise');
    }
}
