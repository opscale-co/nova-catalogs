Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'nova-catalogs',
            path: '/nova-catalogs',
            component: require('./components/Tool').default,
        },
    ])
})
