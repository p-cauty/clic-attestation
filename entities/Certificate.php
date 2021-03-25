<?php

namespace PitouFW\Entity;

use Exception;
use PitouFW\Core\Utils;
use PitouFW\Model\CertificateModel;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use chillerlan\QRCode\QRCode;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;

class Certificate {
    const CONTEXT_QUARANTINE = 'quarantine';
    const CONTEXT_CURFEW = 'curfew';

    const REASON_WORK = 'travail';
    const REASON_HEALTH = 'sante';
    const REASON_FAMILY = 'famille';
    const REASON_DISABILITY = 'handicap';
    const REASON_LEGAL = 'judiciaire';
    const REASON_PUBLIC_INTEREST = 'missions';
    const REASON_TRANSIT = 'transit';
    const REASON_PET = 'animaux';
    const REASON_WORKOUT = 'sport';
    const REASON_GROCERIES = 'achats';
    const REASON_CHILDREN = 'enfants';
    const REASON_CULT = 'culte_culturel';
    const REASON_PROCEDURE = 'demarche';
    const REASON_MOVING = 'demenagement';

    const COORDINATES = [
        self::CONTEXT_QUARANTINE => [
            'citizen' => [
                'identity' => [40, 115],
                'birth_date' => [40, 120],
                'birth_location' => [76, 120],
                'street_address' => [46, 125]
            ],
            'timestamp' => [
                'made_in' => [21, 260],
                'date' => [21, 265],
                'time' => [100, 265],
                'notice' => [21, 270]
            ]
        ],
        self::CONTEXT_CURFEW => [
            'citizen' => [
                'identity' => [43, 49],
                'birth_date' => [43, 55.7],
                'birth_location' => [111, 55.7],
                'street_address' => [48, 62.6]
            ],
            'timestamp' => [
                'made_in' => [25, 260],
                'date' => [25, 265],
                'time' => [100, 265],
                'notice' => [25, 270]
            ]
        ]
    ];

    const X_REASON = [
        self::CONTEXT_QUARANTINE => 21,
        self::CONTEXT_CURFEW => 25.4
    ];

    const Y_REASON = [
        self::CONTEXT_QUARANTINE => [
            self::REASON_WORKOUT => 168,
            self::REASON_GROCERIES => 211,
            self::REASON_CHILDREN => 240,
            self::REASON_CULT => 22,
            self::REASON_PROCEDURE => 41,
            self::REASON_WORK => 75,
            self::REASON_HEALTH => 109.5,
            self::REASON_FAMILY => 129,
            self::REASON_DISABILITY => 148,
            self::REASON_LEGAL => 163,
            self::REASON_MOVING => 187,
            self::REASON_TRANSIT => 211.5
        ],
        self::CONTEXT_CURFEW => [
            self::REASON_WORK => 93,
            self::REASON_HEALTH => 105,
            self::REASON_FAMILY => 116.5,
            self::REASON_DISABILITY => 128,
            self::REASON_LEGAL => 136,
            self::REASON_PUBLIC_INTEREST => 152,
            self::REASON_TRANSIT => 164,
            self::REASON_PET => 175.5
        ]
    ];

    private bool $is_curfew = false;
    private string $context = self::CONTEXT_CURFEW;

    private ?Citizen $citizen = null;
    private ?Fpdi $pdf = null;

    private ?string $reason = null;
    private string $made_in = '';
    private int $made_at = 0;

    private string $filename = '';

    /**
     * Attestation constructor.
     */
    public function __construct() {
        $this->is_curfew = CertificateModel::isCurfew();
        $this->context = $this->is_curfew ? self::CONTEXT_CURFEW : self::CONTEXT_QUARANTINE;

        $this->pdf = new Fpdi();
        $this->pdf->SetAuthor("Ministère de l'intérieur");
        $this->pdf->AddPage();

        try {
            if ($this->is_curfew) {
                $this->pdf->setSourceFile(ROOT . 'certificate.curfew.pdf');
            } else {
                $this->pdf->setSourceFile(ROOT . 'certificate.quarantine.pdf');
            }
        } catch (PdfParserException $e) {
            die('impossible de parser le PDF : ' . $e->getMessage());
        }

        try {
            $tpl = $this->pdf->importPage(1);
        } catch (Exception $e) {
            die('erreur lors de l\'import de la page 1');
        }

        $this->pdf->useTemplate($tpl);
        $this->made_at = Utils::time();
    }

    /**
     * @return $this
     */
    public function generate(): Certificate {
        $this->_handleCitizen();

        if ($this->is_curfew) {
            $this->_handleReason();
        } else {
            if (in_array($this->reason, [self::REASON_WORKOUT, self::REASON_GROCERIES, self::REASON_CHILDREN])) {
                $this->_handleReason();
                try {
                    $tpl = $this->pdf->importPage(2);
                } catch (Exception $e) {
                    die('erreur lors de l\'import de la page 2');
                }
                $this->pdf->AddPage();
                $this->pdf->useTemplate($tpl);
            } else {
                try {
                    $tpl = $this->pdf->importPage(2);
                } catch (Exception $e) {
                    die('erreur lors de l\'import de la page 2');
                }
                $this->pdf->AddPage();
                $this->pdf->useTemplate($tpl);
                $this->_handleReason();
            }
        }

        $this->_handleTimestamp()
            ->_sign();

        return $this;
    }

    public function show() {
        $this->pdf->Output('I', $this->filename);
    }

    public function download() {
        $this->pdf->Output('D', $this->filename);
    }

    /**
     * @return Certificate
     */
    private function _handleCitizen(): Certificate {
        if ($this->citizen === null) {
            die('données incomplètes');
        }

        $this->pdf->SetFont('Helvetica', 'B', 10);
        $this->pdf->SetTextColor(0, 0, 0);

        $this->pdf->Text(self::COORDINATES[$this->context]['citizen']['identity'][0], self::COORDINATES[$this->context]['citizen']['identity'][1], CertificateModel::handleUTF8($this->citizen->getFirstname() . ' ' . $this->citizen->getLastname()));
        $this->pdf->Text(self::COORDINATES[$this->context]['citizen']['birth_date'][0], self::COORDINATES[$this->context]['citizen']['birth_date'][1], $this->citizen->getBirthDate());
        $this->pdf->Text(self::COORDINATES[$this->context]['citizen']['birth_location'][0], self::COORDINATES[$this->context]['citizen']['birth_location'][1], CertificateModel::handleUTF8($this->citizen->getBirthLocation()));
        $this->pdf->Text(self::COORDINATES[$this->context]['citizen']['street_address'][0], self::COORDINATES[$this->context]['citizen']['street_address'][1], CertificateModel::handleUTF8($this->citizen->getStreetAddress()));

        return $this;
    }

    /**
     * @return Certificate
     */
    private function _handleReason(): Certificate {
        if (!isset(self::Y_REASON[$this->context][$this->reason])) {
            die('Raison invalide');
        }

        $this->pdf->SetFont('Helvetica', 'B', 12);
        $this->pdf->Text(self::X_REASON[$this->context], self::Y_REASON[$this->context][$this->reason], 'X');

        return $this;
    }

    /**
     * @return Certificate
     */
    private function _handleTimestamp(): Certificate {
        if ($this->reason === null || $this->made_in === '' || $this->made_at <= 0) {
            die('données incomplètes');
        }

        $this->pdf->SetFont('Helvetica', '', 10);
        $this->pdf->SetTextColor(0, 0, 0);

        $this->pdf->Text(
            self::COORDINATES[$this->context]['timestamp']['made_in'][0],
            self::COORDINATES[$this->context]['timestamp']['made_in'][1],
            CertificateModel::handleUTF8('Fait à ' . $this->made_in)
        );
        $this->pdf->Text(
            self::COORDINATES[$this->context]['timestamp']['date'][0],
            self::COORDINATES[$this->context]['timestamp']['date'][1],
            CertificateModel::handleUTF8('Le ' . date('d/m/Y', $this->made_at))
        );
        $this->pdf->Text(
            self::COORDINATES[$this->context]['timestamp']['time'][0],
            self::COORDINATES[$this->context]['timestamp']['time'][1],
            CertificateModel::handleUTF8('à ' . date('H:i', $this->made_at))
        );
        $this->pdf->Text(
            self::COORDINATES[$this->context]['timestamp']['notice'][0],
            self::COORDINATES[$this->context]['timestamp']['notice'][1],
            CertificateModel::handleUTF8('(Date et heure de début de sortie à mentionner obligatoirement)')
        );

        $this->filename = 'attestation-' . date('Y-m-d_H-i', $this->made_at) . '.pdf';

        return $this;
    }

    /**
     * @return Certificate
     */
    private function _sign(): Certificate {
        $qrcode = new QRCode();
        $imgUrl = $qrcode->render(
            'Cree le: ' . date('d/m/Y \a H\hi', $this->made_at) . ";\n" .
            'Nom: ' . $this->citizen->getLastname() . ";\n" .
            'Prenom: ' . $this->citizen->getFirstname() . ";\n" .
            'Naissance: ' . $this->citizen->getBirthDate() . ' a ' . $this->citizen->getBirthLocation() . ";\n" .
            'Adresse: ' . $this->citizen->getStreetAddress() . ";\n" .
            'Sortie: ' . date('d/m/Y \a H:i', $this->made_at) . ";\n" .
            'Motifs: ' . $this->reason
        );
        $this->pdf->Image($imgUrl, 165, 235, 35, 35, 'png');
        $this->pdf->AddPage();
        $this->pdf->Image($imgUrl, 7, 7, 120, 120, 'png');

        return $this;
    }

    /**
     * @param Citizen|null $citizen
     * @return Certificate
     */
    public function setCitizen(?Citizen $citizen): Certificate {
        $this->citizen = $citizen;
        return $this;
    }

    /**
     * @param string|null $reason
     * @return Certificate
     */
    public function setReason(?string $reason): Certificate {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @param string $made_in
     * @return Certificate
     */
    public function setMadeIn(string $made_in): Certificate {
        $this->made_in = $made_in;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string {
        return $this->filename;
    }
}
