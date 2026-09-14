import options from '../fixtures/options.json'

/** El fixture compartido, con los ids que trae la respuesta real del index. */
export const optionsWithIds = () => options.map((option, index) => ({ id: index + 1, ...option }))

export const themeFixture = () => JSON.parse(options.find((option) => option.key === 'theme').value)

export const siteNameFixture = () => options.find((option) => option.key === 'site_name').value
