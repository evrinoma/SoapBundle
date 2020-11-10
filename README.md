#Configuration

    soap:
        url: custom url
        cache:  evrinoma.file.cache | evrinoma.redis.cache - adaptor to cache should implement CacheAdapterInterface
        settings:
            redis:
                host: localhost
                port:   6379
            file:
                extension: wsdl
                path: ~
            example:
                dummy: false | true - register example soap service's
                
#Annotation
   @Exclude - to remove method class from soap implementation please use this annotation
      
#How to register services
Registration as service:
--------------------------------------------
      App\Service\MailService:
        public: true
        autowire: true
        autoconfigure: true
        tags:
          - { name: evrinoma.service.soap }
      
Soap AbstractClass implementation:
--------------------------------------------
    /**
     * Class MailService
     *
     * @package App\Service
     */
    class MailService extends AbstractSoapService
    {
        private   $mailer;
        protected $route = 'mail';
    
        /**
         * MailService constructor.
         *
         * @Exclude
         *
         * @param \Swift_Mailer $mailer
         */
        public function __construct(\Swift_Mailer $mailer)
        {
            $this->mailer = $mailer;
        }
    
        /**
         * @param string $recipient
         * @param string $subject
         * @param string $messageBody
         *
         * @return App\Service\MailAnswer
         */
        public function sendMail(string $recipient, string $subject, string $messageBody)
        {
              .....
        }
    }

Soap AbstractClass implementation:
--------------------------------------------
    /**
     * Class MailService
     *
     * @package App\Service
     */
    class MailService implements SoapServiceInterface
    {
        private   $mailer;
    
        /**
         * MailService constructor.
         * @Exclude
         * @param \Swift_Mailer $mailer
         */
        public function __construct(\Swift_Mailer $mailer)
        {
            $this->mailer = $mailer;
        }
    
        /**
         * @param string $recipient
         * @param string $subject
         * @param string $messageBody
         *
         * @return App\Service\MailAnswer
         */
        public function sendMail(string $recipient, string $subject, string $messageBody)
        {
            .....
        }        

        /**
         * @Exclude
         */
        public function getRoute(): string
        {
            return 'mail';
        }
    
        /**
         * @Exclude
         */
        public function getClass(): string
        {
            return static::class;
        }
    
        /**
         * @Exclude
         */
        public function getServiceName(): string
        {
            $reflect = new \ReflectionClass($this->getClass());
    
            return $reflect->getShortName();
        }
    }

#Basic user Authentication 
    soap:
      http_basic:
        realm: Secured Area
      pattern: ^/evrinoma/soap/*
      provider: core_provider
      