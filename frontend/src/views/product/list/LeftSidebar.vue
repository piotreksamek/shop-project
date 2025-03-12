<template>
  <BCol md="3" class="left-sidebar">
    <BCard title="Filtry" class="h-100">
      <BForm>
        <BFormGroup label="Kategoria">
          <BFormSelect>
            <option value="">Wszystkie</option>
            <option value="electronics">Elektronika</option>
            <option value="clothing">Odzież</option>
            <option value="home">Dom</option>
          </BFormSelect>
        </BFormGroup>

        <BButton variant="primary mt-5">Zastosuj filtry</BButton>
      </BForm>
    </BCard>
  </BCol>
</template>
