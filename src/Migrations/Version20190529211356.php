<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190529211356 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, color VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_recette (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_recette (id INT AUTO_INCREMENT NOT NULL, id_order_id INT DEFAULT NULL, id_recette_id INT DEFAULT NULL, INDEX IDX_BF001130DD4481AD (id_order_id), INDEX IDX_BF0011302CBBAF3E (id_recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_stock (id INT AUTO_INCREMENT NOT NULL, id_stock_id INT DEFAULT NULL, id_order_id INT DEFAULT NULL, INDEX IDX_725E89A35D168D85 (id_stock_id), INDEX IDX_725E89A3DD4481AD (id_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE number_people (id INT AUTO_INCREMENT NOT NULL, number INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, quanity_gram INT DEFAULT NULL, quantity_unit INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_recette (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, picture_recette VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE places (id INT AUTO_INCREMENT NOT NULL, stock_id INT DEFAULT NULL, name VARCHAR(15) DEFAULT NULL, drawers INT DEFAULT NULL, INDEX IDX_FEAF6C55DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, id_category_product_id INT DEFAULT NULL, id_picture_product_id INT DEFAULT NULL, stock_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD2570AAEF (id_category_product_id), UNIQUE INDEX UNIQ_D34A04ADEA7694F2 (id_picture_product_id), INDEX IDX_D34A04ADDCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_recette (id INT AUTO_INCREMENT NOT NULL, id_product_id INT DEFAULT NULL, id_recette_id INT DEFAULT NULL, INDEX IDX_98627820E00EE68D (id_product_id), INDEX IDX_986278202CBBAF3E (id_recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, id_picture_recette_id INT DEFAULT NULL, id_category_recette_id INT DEFAULT NULL, id_number_people_id INT DEFAULT NULL, id_book_id INT DEFAULT NULL, id_page_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, quantity_gram INT DEFAULT NULL, quantity_unit INT DEFAULT NULL, time_prepa VARCHAR(11) DEFAULT NULL, time_cook INT NOT NULL, description VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_49BB639026C3DD41 (id_picture_recette_id), INDEX IDX_49BB6390E9C5E35C (id_category_recette_id), INDEX IDX_49BB6390FF4F619F (id_number_people_id), INDEX IDX_49BB6390C83F1AF1 (id_book_id), INDEX IDX_49BB6390D2DBCA94 (id_page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, quantity_gram INT DEFAULT NULL, quantity_unit INT DEFAULT NULL, dlc VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_recette ADD CONSTRAINT FK_BF001130DD4481AD FOREIGN KEY (id_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE commande_recette ADD CONSTRAINT FK_BF0011302CBBAF3E FOREIGN KEY (id_recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE commande_stock ADD CONSTRAINT FK_725E89A35D168D85 FOREIGN KEY (id_stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE commande_stock ADD CONSTRAINT FK_725E89A3DD4481AD FOREIGN KEY (id_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE places ADD CONSTRAINT FK_FEAF6C55DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2570AAEF FOREIGN KEY (id_category_product_id) REFERENCES category_product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADEA7694F2 FOREIGN KEY (id_picture_product_id) REFERENCES picture_product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE product_recette ADD CONSTRAINT FK_98627820E00EE68D FOREIGN KEY (id_product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_recette ADD CONSTRAINT FK_986278202CBBAF3E FOREIGN KEY (id_recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB639026C3DD41 FOREIGN KEY (id_picture_recette_id) REFERENCES picture_recette (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390E9C5E35C FOREIGN KEY (id_category_recette_id) REFERENCES category_recette (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390FF4F619F FOREIGN KEY (id_number_people_id) REFERENCES number_people (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390C83F1AF1 FOREIGN KEY (id_book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390D2DBCA94 FOREIGN KEY (id_page_id) REFERENCES page (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390C83F1AF1');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2570AAEF');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390E9C5E35C');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390FF4F619F');
        $this->addSql('ALTER TABLE commande_recette DROP FOREIGN KEY FK_BF001130DD4481AD');
        $this->addSql('ALTER TABLE commande_stock DROP FOREIGN KEY FK_725E89A3DD4481AD');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390D2DBCA94');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADEA7694F2');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB639026C3DD41');
        $this->addSql('ALTER TABLE product_recette DROP FOREIGN KEY FK_98627820E00EE68D');
        $this->addSql('ALTER TABLE commande_recette DROP FOREIGN KEY FK_BF0011302CBBAF3E');
        $this->addSql('ALTER TABLE product_recette DROP FOREIGN KEY FK_986278202CBBAF3E');
        $this->addSql('ALTER TABLE commande_stock DROP FOREIGN KEY FK_725E89A35D168D85');
        $this->addSql('ALTER TABLE places DROP FOREIGN KEY FK_FEAF6C55DCD6110');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADDCD6110');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE category_product');
        $this->addSql('DROP TABLE category_recette');
        $this->addSql('DROP TABLE commande_recette');
        $this->addSql('DROP TABLE commande_stock');
        $this->addSql('DROP TABLE number_people');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE picture_product');
        $this->addSql('DROP TABLE picture_recette');
        $this->addSql('DROP TABLE places');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_recette');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE stock');
    }
}
