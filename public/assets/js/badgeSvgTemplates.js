const BadgeSvgTemplates = {
    circle: (config) => `
        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">
            <defs>
                <linearGradient id="badgeGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:${config.primaryColor}" />
                    <stop offset="100%" style="stop-color:${config.secondaryColor}" />
                </linearGradient>
            </defs>
            <circle cx="100" cy="100" r="100" fill="url(#badgeGradient)"/>
            <text x="100" y="90" text-anchor="middle" fill="white" style="font-size: 18px; font-weight: bold; font-family: Arial;">${config.title}</text>
            <text x="100" y="120" text-anchor="middle" fill="white" style="font-size: 14px; font-family: Arial;">${config.recipient}</text>
        </svg>`,

    hexagon: (config) => `
        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="230" viewBox="0 0 200 230" preserveAspectRatio="xMidYMid meet">
            <defs>
                <linearGradient id="badgeGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:${config.primaryColor}" />
                    <stop offset="100%" style="stop-color:${config.secondaryColor}" />
                </linearGradient>
                <clipPath id="hexagonClip">
                    <path d="M100 0 L200 57.5 L200 172.5 L100 230 L0 172.5 L0 57.5 Z" />
                </clipPath>
            </defs>
            
            <g clip-path="url(#hexagonClip)">
                <path d="M100 0 L200 57.5 L200 172.5 L100 230 L0 172.5 L0 57.5 Z" 
                      fill="url(#badgeGradient)" />
            </g>

            <g transform="translate(100, 115)">
                <text x="0" y="0" 
                      text-anchor="middle" 
                      fill="white" 
                      style="font-size: 24px; font-weight: bold; font-family: Arial, sans-serif;">
                    ${config.title}
                </text>
                
                <text x="0" y="30" 
                      text-anchor="middle" 
                      fill="white" 
                      style="font-size: 16px; font-family: Arial, sans-serif;">
                    ${config.recipient}
                </text>
            </g>
        </svg>`,

    shield: (config) => `
        <svg xmlns="http://www.w3.org/2000/svg" width="180" height="240" viewBox="0 0 180 240">
            <defs>
                <linearGradient id="badgeGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:${config.primaryColor}" />
                    <stop offset="100%" style="stop-color:${config.secondaryColor}" />
                </linearGradient>
            </defs>
            <path d="M90 0 L180 60 L180 150 Q180 240 90 240 Q0 240 0 150 L0 60 Z" fill="url(#badgeGradient)"/>
            <text x="90" y="120" text-anchor="middle" fill="white" style="font-size: 18px; font-weight: bold; font-family: Arial;">${config.title}</text>
            <text x="90" y="150" text-anchor="middle" fill="white" style="font-size: 14px; font-family: Arial;">${config.recipient}</text>
        </svg>`,

    ribbon: (config) => `
        <svg xmlns="http://www.w3.org/2000/svg" width="220" height="260" viewBox="0 0 220 260">
            <defs>
                <linearGradient id="badgeGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:${config.primaryColor}" />
                    <stop offset="100%" style="stop-color:${config.secondaryColor}" />
                </linearGradient>
            </defs>
            <path d="M110 0 L220 60 L220 200 L110 260 L0 200 L0 60 Z" fill="url(#badgeGradient)"/>
            <path d="M110 260 L85 230 L110 240 L135 230 L110 260" fill="url(#badgeGradient)"/>
            <text x="110" y="130" text-anchor="middle" fill="white" style="font-size: 18px; font-weight: bold; font-family: Arial;">${config.title}</text>
            <text x="110" y="160" text-anchor="middle" fill="white" style="font-size: 14px; font-family: Arial;">${config.recipient}</text>
        </svg>`
};
