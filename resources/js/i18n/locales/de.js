export default {

    dashboard: 'Dashboard',
    orders: 'Bestellungen',
    stockCheckRequests: 'Lagerbestandsüberprüfungen',
    quoteRequests: 'Angebotsanfragen',
    reservations: 'Reservierungen',
    customers: 'Kunden',
    bulletin: 'Bulletin',
    category: 'Kategorie',
    categories: 'Kategorien',
    content_system: 'Content-System',
    products: 'Produkte',
    roles: 'Rollen',
    users: 'Benutzer',
    settings: 'Einstellungen',
    logout: 'Abmelden',
    profile: 'Profil',
    about: 'Über uns',
    contact: 'Kontakt',
    privacy: 'Datenschutz',
    terms: 'Nutzungsbedingungen',
    aboutText: 'Wir bieten umfassende Restaurantmanagementlösungen, um Unternehmen beim Wachstum und Erfolg im modernen digitalen Zeitalter zu unterstützen.',
    passwordChange: 'Passwort ändern',
    restaurantSettings: 'Restaurant-Einstellungen',
    notifications: 'Benachrichtigungen',
    changeLanguage: 'Sprache ändern',
    restaurants: 'Restaurants',

    //Main Home Page
    welcome: 'Willkommen bei Restro Verwalten',
    subtitle: 'Ihre ultimative Restaurant-Management-Lösung',
    getStarted: 'JETZT STARTEN',
    learnMore: 'MEHR ERFAHREN',
    whyChoose: 'Warum Restro Verwalten wählen?',
    about_us: 'Über US',

    // Navigation
    nav: {
        home: 'Startseite',
        features: 'Funktionen',
        pricing: 'Preise',
        contact: 'Kontakt',
        login: 'Anmelden',
        register: 'Registrieren',
        users: 'Benutzer',
        roles_permissions: 'Rollen & Berechtigungen',
        tenants: 'Restaurants',
        logout: 'Abmelden',
        profile: 'Profil',


        // Frontend lang
        foodOrdering: 'Essensbestellung',
        restaurantServices: 'Restaurant-Dienstleistungen',
        pricing: 'Preise',
        getAccess: 'Jetzt Zugang erhalten'
    },
    topbar: {
        phone: import.meta.env.VITE_CONTACT_PHONE || '+1 234 567 8900',
        language: 'Sprache'
    },
    footer: {
        aboutUs: 'Über uns',
        contact: 'Kontakt',
        privacy: 'Datenschutzrichtlinie',
        terms: 'Nutzungsbedingungen',
        aboutText: 'Wir bieten umfassende Restaurantmanagementlösungen, um Unternehmen beim Wachstum und Erfolg im modernen digitalen Zeitalter zu unterstützen.',
        quickLinks: {
            title: 'Schnellzugriff',
            features: 'Funktionen',
            pricing: 'Preise',
        },
        contactInfo: 'Kontaktinfo',
        address: import.meta.env.VITE_CONTACT_ADDRESS || '123 Business Street, NY 10001',
        phone: import.meta.env.VITE_CONTACT_PHONE || '+1 234 567 8900',
        hours: import.meta.env.VITE_CONTACT_HOURS || 'Mo - Fr: 9:00 - 18:00 Uhr',
        copyright: '© 2024 Restaurant Management System. Alle Rechte vorbehalten.',
        about: {
            title: 'Über uns',
            description: 'Wir bieten umfassende Restaurantmanagementlösungen, um Unternehmen beim Wachstum und Erfolg im modernen digitalen Zeitalter zu unterstützen.'
        },
        contact: {
            title: 'Kontaktinfo',
            address: import.meta.env.VITE_CONTACT_ADDRESS || '123 Business Street, NY 10001',
            phone: import.meta.env.VITE_CONTACT_PHONE || '+1 234 567 8900',
            hours: import.meta.env.VITE_CONTACT_HOURS || 'Mo - Fr: 9:00 - 18:00 Uhr'
        }
    },
    // Home
    home: {
        welcome: 'Willkommen bei Restro Verwalten',
        subtitle: 'Ihre ultimative Restaurant-Management-Lösung',
        getStarted: 'JETZT STARTEN',
        learnMore: 'MEHR ERFAHREN',
        whyChoose: 'Warum Restro Verwalten wählen?',
        features: {
            quickSetup: {
                title: 'Schnelle Einrichtung',
                description: 'Bringen Sie Ihr Restaurant in wenigen Minuten online mit unserem einfachen Einrichtungsprozess.'
            },
            mobileFriendly: {
                title: 'Mobilfreundlich',
                description: 'Vollständig responsives System funktioniert perfekt auf allen Geräten.'
            },
            analytics: {
                title: 'Analysen',
                description: 'Detaillierte Einblicke und Berichte für das Wachstum Ihres Unternehmens.'
            }
        },
        specialDishes: {
            title: 'Unsere Spezialitäten',
            subtitle: 'Entdecken Sie unsere beliebtesten und köstlichsten Gerichte',
            addToCart: 'In den Warenkorb',
            addedToCart: 'Zum Warenkorb hinzugefügt',
            categories: {
                meat: 'Fleischgerichte',
                chicken: 'Hühnchengerichte',
                desserts: 'Desserts'
            }
        },
        about: {
            title: 'Über unser Restaurant',
            description1: 'Seit 1987 servieren wir unseren geschätzten Kunden authentische und köstliche Speisen. Unsere Mission ist es, ein außergewöhnliches Esserlebnis mit höchster Qualität der Zutaten und professionellem Service zu bieten.',
            description2: 'Unsere Köche sind leidenschaftlich dabei, unvergessliche Gerichte zu kreieren, die traditionelle Rezepte mit modernen Kochtechniken verbinden.',
            learnMore: 'Mehr erfahren'
        },
        testimonials: {
            title: 'Was unsere Kunden sagen',
            subtitle: 'Lesen Sie, was unsere zufriedenen Kunden über uns sagen'
        },
        reservation: {
            title: 'Reservierung vornehmen',
            subtitle: 'Buchen Sie Ihren Tisch online und genießen Sie ein besonderes Esserlebnis',
            contact: {
                call: 'Rufen Sie uns an: (+100) 123 456 7890',
                hours: 'Öffnungszeiten: Mo - So / 9:00 - 20:00 Uhr'
            },
            form: {
                name: 'Ihr Name',
                email: 'Ihre E-Mail',
                guests: 'Anzahl der Gäste',
                bookNow: 'Jetzt buchen'
            }
        }
    },

    // Auth
    auth: {
        login: {
            title: 'In Ihren Account einloggen',
            email: 'E-Mail-Adresse',
            password: 'Passwort',
            remember: 'Angemeldet bleiben',
            submit: 'Anmelden',
            forgot: 'Passwort vergessen?',
            noAccount: 'Noch kein Konto?',
            register: 'Jetzt registrieren'
        },
        register: {
            title: 'Restaurant registrieren',
            restaurantName: 'Restaurant Name',
            domain: 'Domain-Name',
            email: 'E-Mail-Adresse',
            phone: 'Telefonnummer',
            password: 'Passwort',
            confirmPassword: 'Passwort bestätigen',
            address: 'Adresse',
            street: 'Straße',
            postalCode: 'Postleitzahl',
            city: 'Stadt',
            state: 'Bundesland',
            country: 'Land',
            county: 'Landkreis',
            submit: 'Registrieren',
            haveAccount: 'Bereits ein Konto?',
            login: 'Hier anmelden'
        }
    },

    // Dashboard
    main_dashboard: {
        stats: {
            totalTenants: 'Gesamtzahl Restaurants',
            activeTenants: 'Aktive Restaurants',
            pendingTenants: 'Ausstehende Genehmigungen',
            suspendedTenants: 'Gesperrte Restaurants',
            totalUsers: 'Gesamtzahl Benutzer',
            totalRoles: 'Gesamtzahl Rollen',
            totalPermissions: 'Gesamtzahl Berechtigungen',
            activeUsers: 'Aktive Benutzer heute'
        },
        quickActions: {
            title: 'Schnellzugriff',
            manageTenants: 'Restaurants verwalten',
            manageUsers: 'Benutzer verwalten',
            manageRoles: 'Rollen verwalten',
            clearCache: 'Cache leeren'
        }
    },

    // Tenants
    tenants: {
        list: {
            title: 'Restaurants',
            name: 'Name',
            domain: 'Domain',
            owner: 'Besitzer',
            status: 'Status',
            actions: 'Aktionen'
        },
        status: {
            active: 'Aktiv',
            pending: 'Ausstehend',
            suspended: 'Gesperrt',
            trial: 'Testphase'
        },
        actions: {
            view: 'Ansehen',
            edit: 'Bearbeiten',
            delete: 'Löschen',
            approve: 'Genehmigen',
            suspend: 'Sperren',
            activate: 'Aktivieren'
        }
    },

    // Common
    common: {
        save: 'Speichern',
        cancel: 'Abbrechen',
        delete: 'Löschen',
        edit: 'Bearbeiten',
        create: 'Erstellen',
        search: 'Suchen',
        actions: 'Aktionen',
        confirm: 'Bestätigen',
        success: 'Erfolg',
        error: 'Fehler',
        loading: 'Lädt...',
        noData: 'Keine Daten verfügbar'
    },

    // Messages
    messages: {
        confirmDelete: 'Sind Sie sicher, dass Sie diesen Eintrag löschen möchten?',
        deleteSuccess: 'Eintrag erfolgreich gelöscht',
        savingChanges: 'Änderungen werden gespeichert...',
        changesSaved: 'Änderungen erfolgreich gespeichert',
        errorOccurred: 'Ein Fehler ist aufgetreten',
        sessionExpired: 'Ihre Sitzung ist abgelaufen. Bitte melden Sie sich erneut an.',
        unauthorized: 'Sie sind nicht berechtigt, diese Aktion auszuführen.'
    },

    // Roles
    roles_module: {
        name: 'Rollenname',
        description: 'Beschreibung',
        permissions: 'Berechtigungen',
        createRole: 'Rolle erstellen',
        editRole: 'Rolle bearbeiten',
        noRolesFound: 'Keine Rollen gefunden',
        createNewRole: 'Erstellen Sie eine neue Rolle.',
        roleCreated: 'Rolle erfolgreich erstellt',
        roleUpdated: 'Rolle erfolgreich aktualisiert',
        roleDeleted: 'Rolle erfolgreich gelöscht',
        confirmDelete: 'Möchten Sie diese Rolle wirklich löschen?',
        errorFetchingRoles: 'Fehler beim Laden der Rollen',
        errorFetchingPermissions: 'Fehler beim Laden der Berechtigungen',
        errorSavingRole: 'Fehler beim Speichern der Rolle',
        errorDeletingRole: 'Fehler beim Löschen der Rolle'
    }
};
