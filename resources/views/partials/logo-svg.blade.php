<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" fill="none">
  <!-- Shield background -->
  <path d="M40 4 L70 16 L70 44 C70 60 56 72 40 76 C24 72 10 60 10 44 L10 16 Z"
        fill="{{ isset($white) && $white ? 'rgba(255,255,255,0.15)' : '#1a3eb3' }}"/>
  <!-- S letter left half -->
  <path d="M22 24 L22 32 L34 32 L34 36 L22 36 L22 52 L36 52 L36 44 L28 44 L28 40 L36 40 L36 24 Z"
        fill="white"/>
  <!-- B letter right half -->
  <path d="M42 24 L42 52 L54 52 C58 52 60 49 60 46 C60 43 58 40 55 40 C58 39 60 37 60 34 C60 31 58 28 54 28 L42 24 Z"
        fill="{{ isset($white) && $white ? 'rgba(255,255,255,0.15)' : '#1a3eb3' }}"/>
  <!-- Refined SB mark - S shape -->
  <rect x="19" y="20" width="20" height="5" rx="2" fill="white"/>
  <rect x="19" y="20" width="5" height="18" rx="2" fill="white"/>
  <rect x="19" y="35" width="20" height="5" rx="2" fill="white"/>
  <rect x="34" y="35" width="5" height="18" rx="2" fill="white"/>
  <rect x="19" y="48" width="20" height="5" rx="2" fill="white"/>
  <!-- B shape -->
  <rect x="44" y="20" width="5" height="33" rx="2" fill="white"/>
  <rect x="44" y="20" width="16" height="5" rx="2" fill="white"/>
  <rect x="44" y="34" width="14" height="5" rx="2" fill="white"/>
  <rect x="44" y="48" width="16" height="5" rx="2" fill="white"/>
  <rect x="55" y="20" width="5" height="18" rx="2.5" fill="white"/>
  <rect x="55" y="34" width="5" height="19" rx="2.5" fill="white"/>
</svg>
